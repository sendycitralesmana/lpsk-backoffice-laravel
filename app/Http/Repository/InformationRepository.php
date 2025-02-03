<?php

namespace App\Http\Repository;

use App\Models\Information;
use App\Models\InformationDocuments;
use App\Models\InformationImages;
use App\Models\InformationVideos;
use DOMDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InformationRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $information = Information::orderBy('created_at', 'desc');

            if ($request->search) {
                $information->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->slug) {
                $information->where('slug', 'like', '%' . $request->slug . '%');
            }

            if ($request->category_id) {
                $information->where('information_category_id', $request->category_id);
            }

            if ($request->category_slug) {   
                $information->whereHas('informationCategory', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $information->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $information = $information->paginate($per_page);

            return $information;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // getLatestApi 5 information
    public function getLatestApi()
    {
        try {
            return Information::orderBy('created_at', 'desc')->limit(4)->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll($data)
    {
        try {
            $informations = Information::orderBy('created_at', 'desc');

            if ($data->search) {
                $informations->where('title', 'like', '%' . $data->search . '%');
            }

            if ($data->category_id) {
                $informations->where('information_category_id', $data->category_id);
            }

            if ($data->user_id) {
                $informations->where('user_id', $data->user_id);
            }

            if ($data->status) {
                $informations->where('status', $data->status);
            }

            if (Auth::user()->role_id == 1) {
                return $informations->paginate(12);
            } else {
                return $informations->where('user_id', Auth::user()->id)->paginate(12);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Information::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $information = new Information();
            $information->id = Str::uuid();
            $information->slug = null;
            $information->information_category_id = $data->information_category_id;
            $information->user_id = Auth::user()->id;
            $information->title = $data->title;
            
            
            // $information->content = $data->content;

            $content = $data->content;

            if ($content == null) {
                $information->content = null;
            } else {
                $dom = new \DomDocument();
                $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                $imageFile = $dom->getElementsByTagName('img');
    
                foreach ($imageFile as $item => $image) {
                    $dataImg = $image->getAttribute('src');
                    list($type, $dataImg) = explode(';', $dataImg);
                    list(, $dataImg)      = explode(',', $dataImg);
                    $imgeDataImg = base64_decode($dataImg);
    
                    // get image extension
                    $image_info = getimagesizefromstring($imgeDataImg);
                    $image_extension = image_type_to_extension($image_info[2]);
    
                    $image_name= "information/description/" . time().$item.$image_extension;
    
                    Storage::disk('s3')->put($image_name, $imgeDataImg, 'public');
    
                    $image->removeAttribute('src');
    
                    $image->setAttribute('src', 'https://bucket.mareca.my.id/lpsk/'.  $image_name);
                }
    
                $content = $dom->saveHTML();
                $information->content = $content;
            }



            if (Auth::user()->role_id == 1) {
                $information->status = "DINAIKAN";
            } else {
                $information->status = "DIAJUKAN";
            }
            if ($data->file('cover')) {
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/information/cover', $file);
                $information->cover = '/' . $path;
            }
            $information->save();

            // insert image
            if ($data->file('image')) {
                foreach ($data->file('image') as $key => $image) {
                    $filename = $data->file('image')[$key]->getClientOriginalName();
                    $extension = $data->file('image')[$key]->getClientOriginalExtension();
                    $size = $data->file('image')[$key]->getSize();
                    $url = $data->file('image')[$key];
                    $store = Storage::disk('s3')->put('/information/images', $url);

                    $informationImage = array(
                        'id' => Str::uuid(),
                        'information_id' => $information->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    InformationImages::create($informationImage);
                }
            }

            // insert video
            if ($data->file('video')) {
                foreach ($data->file('video') as $key => $video) {
                    $filename = $data->file('video')[$key]->getClientOriginalName();
                    $extension = $data->file('video')[$key]->getClientOriginalExtension();
                    $size = $data->file('video')[$key]->getSize();
                    $url = $data->file('video')[$key];
                    $store = Storage::disk('s3')->put('/information/videos', $url);

                    $informationVideo = array(
                        'id' => Str::uuid(),
                        'information_id' => $information->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $url,
                    );
                    InformationVideos::create($informationVideo);
                }
            }

            // insert document
            if ($data->file('document')) {
                foreach ($data->file('document') as $key => $document) {
                    $filename = $data->file('document')[$key]->getClientOriginalName();
                    $extension = $data->file('document')[$key]->getClientOriginalExtension();
                    $size = $data->file('document')[$key]->getSize();
                    $url = $data->file('document')[$key];
                    $store = Storage::disk('s3')->put('/information/documents', $url);

                    $informationDocument = array(
                        'id' => Str::uuid(),
                        'information_id' => $information->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $url,
                    );
                    InformationDocuments::create($informationDocument);
                }
            }

            DB::commit();

            return $information;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $informations = Information::where('id', '!=', $id)->get();
            $information = Information::find($id);
            $information->information_category_id = $data->information_category_id;
            // foreach ($informations as $information) {
            //     if ($information->title == $data->title) {
            //         return redirect()->back()->with('error', 'Judul ' . $data->title . ' telah digunakan');
            //     }
            // }
            $information->title = $data->title;
            
            // $information->content = $data->content;

            $content = $data->content;
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                if (strpos($image->getAttribute('src'), 'data:image') === 0) {
                    $dataImg = $image->getAttribute('src');
                    list($type, $dataImg) = explode(';', $dataImg);
                    list(, $dataImg)      = explode(',', $dataImg);
                    $imgeDataImg = base64_decode($dataImg);
    
                    // get image extension
                    $image_info = getimagesizefromstring($imgeDataImg);
                    $image_extension = image_type_to_extension($image_info[2]);
    
                    $image_name= "information/description/" . time().$item.$image_extension;
    
                    Storage::disk('s3')->put($image_name, $imgeDataImg, 'public');
    
                    $image->removeAttribute('src');
    
                    $image->setAttribute('src', 'https://bucket.mareca.my.id/lpsk/'.  $image_name);
                }
            }

            $content = $dom->saveHTML();
            $information->content = $content;

            if ($data->file('cover')) {
                if ($information->cover) {
                    Storage::disk('s3')->delete($information->cover);
                }
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/information/covers', $file);
                $information->cover = '/' . $path;
            }
            $information->slug = str_replace(' ', '-', strtolower($data->document_name));
            $information->status = $data->status;
            $information->save();
            return $information;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllImage($id)
    {
        try {
            $informationImages = InformationImages::where('information_id', $id)->get();
            foreach ($informationImages as $informationImage) {
                if ($informationImage->url) {
                    Storage::disk('s3')->delete($informationImage->url);
                }
                $informationImage->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $information = Information::find($id);
            if ($information->cover) {
                Storage::disk('s3')->delete($information->cover);
            }
            $information->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeImage($data, $id)
    {
        try {
            $information = Information::find($id);
            if ($data->file('image')) {
                foreach ($data->file('image') as $key => $image) {
                    $filename = $data->file('image')[$key]->getClientOriginalName();
                    $extension = $data->file('image')[$key]->getClientOriginalExtension();
                    $size = $data->file('image')[$key]->getSize();
                    $url = $data->file('image')[$key];
                    $store = Storage::disk('s3')->put('/information/images', $url);

                    $informationImage = array(
                        'id' => Str::uuid(),
                        'information_id' => $information->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    InformationImages::create($informationImage);
                }
            }

            return $information;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteImage($id, $image_id)
    {
        try {
            $information = InformationImages::find($image_id);
            if ($information->url) {
                Storage::disk('s3')->delete($information->url);
            }
            $information->delete();
            return $information;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateImage($data, $id, $image_id)
    {
        try {
            $information = InformationImages::find($image_id);
            if ($data->file('image')) {
                if ($information->url) {
                    Storage::disk('s3')->delete($information->url);
                }
                $filename = $data->file('image')->getClientOriginalName();
                $extension = $data->file('image')->getClientOriginalExtension();
                $size = $data->file('image')->getSize();
                $information->name = $filename;
                $information->extension = $extension;
                $information->size = $size;
                $file = $data->file('image');
                $path = Storage::disk('s3')->put('/information/images', $file);
                $information->url = '/' . $path;
            }
            $information->save();
            return $information;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeVideo($data, $id)
    {
        try {
            $information = Information::find($id);
            if ($data->file('video')) {
                foreach ($data->file('video') as $key => $video) {
                    $filename = $data->file('video')[$key]->getClientOriginalName();
                    $extension = $data->file('video')[$key]->getClientOriginalExtension();
                    $size = $data->file('video')[$key]->getSize();
                    $url = $data->file('video')[$key];
                    $store = Storage::disk('s3')->put('/information/videos', $url);

                    $informationVideo = array(
                        'id' => Str::uuid(),
                        'information_id' => $information->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    InformationVideos::create($informationVideo);
                }
            }

            return $information;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteVideo($id, $video_id)
    {
        try {
            $informationVideo = InformationVideos::find($video_id);
            if ($informationVideo->url) {
                Storage::disk('s3')->delete($informationVideo->url);
            }
            $informationVideo->delete();
            return $informationVideo;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateVideo($data, $id, $video_id)
    {
        try {
            $informationVideo = InformationVideos::find($video_id);
            if ($data->file('video')) {
                if ($informationVideo->url) {
                    Storage::disk('s3')->delete($informationVideo->url);
                }
                $filename = $data->file('video')->getClientOriginalName();
                $extension = $data->file('video')->getClientOriginalExtension();
                $size = $data->file('video')->getSize();
                $informationVideo->name = $filename;
                $informationVideo->extension = $extension;
                $informationVideo->size = $size;
                $file = $data->file('video');
                $path = Storage::disk('s3')->put('/information/videos', $file);
                $informationVideo->url = '/' . $path;
            }
            $informationVideo->save();
            return $informationVideo;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllVideo($id)
    {
        try {
            $informationVideos = InformationVideos::where('information_id', $id)->get();
            foreach ($informationVideos as $informationVideo) {
                if ($informationVideo->url) {
                    Storage::disk('s3')->delete($informationVideo->url);
                }
                $informationVideo->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeDocument($data, $id)
    {
        try {
            $information = Information::find($id);
            if ($data->file('document')) {
                foreach ($data->file('document') as $key => $document) {
                    $filename = $data->file('document')[$key]->getClientOriginalName();
                    $extension = $data->file('document')[$key]->getClientOriginalExtension();
                    $size = $data->file('document')[$key]->getSize();
                    $url = $data->file('document')[$key];
                    $store = Storage::disk('s3')->put('/information/documents', $url);

                    $informationDocument = array(
                        'id' => Str::uuid(),
                        'information_id' => $information->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    InformationDocuments::create($informationDocument);
                }
            }

            return $information;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteDocument($id, $document_id)
    {
        try {
            $informationDocument = InformationDocuments::find($document_id);
            if ($informationDocument->url) {
                Storage::disk('s3')->delete($informationDocument->url);
            }
            $informationDocument->delete();
            return $informationDocument;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateDocument($data, $id, $document_id)
    {
        try {
            $informationDocument = InformationDocuments::find($document_id);
            if ($data->file('document')) {
                if ($informationDocument->url) {
                    Storage::disk('s3')->delete($informationDocument->url);
                }
                $filename = $data->file('document')->getClientOriginalName();
                $extension = $data->file('document')->getClientOriginalExtension();
                $size = $data->file('document')->getSize();
                $informationDocument->name = $filename;
                $informationDocument->extension = $extension;
                $informationDocument->size = $size;
                $file = $data->file('document');
                $path = Storage::disk('s3')->put('/information/documents', $file);
                $informationDocument->url = '/' . $path;
            }
            $informationDocument->save();
            return $informationDocument;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllDocument($id)
    {
        try {
            $informationDocuments = InformationDocuments::where('information_id', $id)->get();
            foreach ($informationDocuments as $informationDocument) {
                if ($informationDocument->url) {
                    Storage::disk('s3')->delete($informationDocument->url);
                }
                $informationDocument->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}