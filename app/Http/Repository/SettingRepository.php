<?php

namespace App\Http\Repository;

use App\Models\Setting;
use App\Models\SettingDocument;
use App\Models\SettingImage;
use App\Models\SettingVideo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $setting = Setting::with(['user:id,name,email,created_at,updated_at'])->orderBy('created_at', 'desc')->where('status', 'DINAIKAN');

            if ($request->search) {
                $setting->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->category_id) {
                $setting->where('setting_category_id', $request->category_id);
            }

            if ($request->user_id) {
                $setting->where('user_id', $request->user_id);
            }

            if ($request->status) {
                $setting->where('status', $request->status);
            }

            if ($request->category_slug) {   
                $setting->whereHas('settingCategory', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $setting->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $setting = $setting->paginate($per_page);

            return $setting;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll($data)
    {
        try {

            $setting = Setting::orderBy('created_at', 'desc');

            if ($data->search) {
                $setting->where('title', 'like', '%' . $data->search . '%');
            }

            if ($data->category_id) {
                $setting->where('setting_category_id', $data->category_id);
            }

            if ($data->user_id) {
                $setting->where('user_id', $data->user_id);
            }

            if ($data->status) {
                $setting->where('status', $data->status);
            }

            if (Auth::user()->role_id == 1) {
                return $setting->paginate(12);
            } else {
                return $setting->where('user_id', Auth::user()->id)->paginate(12);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Setting::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {

        DB::beginTransaction();

        try {
            $setting = new setting();
            $setting->id = Str::uuid();
            $setting->user_id = Auth::user()->id;
            $setting->setting_category_id = $data->setting_category_id;
            $setting->title = $data->title;
            // $setting->content = $data->content;

            $content = $data->content;
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

                $image_name= "setting/description/" . time().$item.$image_extension;

                Storage::disk('s3')->put($image_name, $imgeDataImg, 'public');

                // $path = public_path() . $image_name;
                // file_put_contents($path, $imgeDataImg);

                $image->removeAttribute('src');

                $image->setAttribute('src', 'https://bucket.mareca.my.id/lpsk/'.  $image_name);
            }

            $content = $dom->saveHTML();
            $setting->content = $content;


            // $content = $data->content;
            // $dom = new DOMDocument();
            // $dom->loadHtml($content, 9);

            // $images = $dom->getElementsByTagName('img');
            // foreach ($images as $key => $image) {

            //     $data = base64_decode(explode(',', explode(';', $image->getAttribute('src'))[1])[1]);
            //     $image_name = "image-" . time() . $key . ".png";
            //     file_put_contents(public_path().$image_name, $data);

            //     $image->removeAttribute('src');
            //     $image->setAttribute('src', $image_name);

            //     $src = $image->getAttribute('src');
            //     $store = Storage::disk('s3')->put('/setting/images', $src);
            //     $image->setAttribute('src', $store);
            // }
            // $setting->content = $content;

            if ($data->file('cover')) {
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/setting/cover', $file);
                $setting->cover = '/' . $path;
            }

            if (Auth::user()->role_id == 1) {
                $setting->status = "DINAIKAN";
            } else {
                $setting->status = "DIAJUKAN";
            }

            $setting->save();

            // insert image
            if ($data->file('image')) {
                foreach ($data->file('image') as $key => $image) {
                    $filename = $data->file('image')[$key]->getClientOriginalName();
                    $extension = $data->file('image')[$key]->getClientOriginalExtension();
                    $size = $data->file('image')[$key]->getSize();
                    $url = $data->file('image')[$key];
                    $store = Storage::disk('s3')->put('/setting/images', $url);

                    $settingImage = array(
                        'id' => Str::uuid(),
                        'setting_id' => $setting->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    SettingImage::create($settingImage);
                }
            }

            // insert video
            if ($data->file('video')) {
                foreach ($data->file('video') as $key => $video) {
                    $filename = $data->file('video')[$key]->getClientOriginalName();
                    $extension = $data->file('video')[$key]->getClientOriginalExtension();
                    $size = $data->file('video')[$key]->getSize();
                    $url = $data->file('video')[$key];
                    $store = Storage::disk('s3')->put('/setting/videos', $url);

                    $settingVideo = array(
                        'id' => Str::uuid(),
                        'setting_id' => $setting->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $url,
                    );
                    SettingVideo::create($settingVideo);
                }
            }

            // insert document
            if ($data->file('document')) {
                foreach ($data->file('document') as $key => $document) {
                    $filename = $data->file('document')[$key]->getClientOriginalName();
                    $extension = $data->file('document')[$key]->getClientOriginalExtension();
                    $size = $data->file('document')[$key]->getSize();
                    $url = $data->file('document')[$key];
                    $store = Storage::disk('s3')->put('/setting/documents', $url);

                    $settingDocument = array(
                        'id' => Str::uuid(),
                        'setting_id' => $setting->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $url,
                    );
                    SettingDocument::create($settingDocument);
                }
            }

            DB::commit();

            return $setting;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $settings = Setting::where('id', '!=', $id)->get();
            $setting = Setting::find($id);
            $setting->setting_category_id = $data->setting_category_id;
            // foreach ($settings as $setting) {
            //     if ($setting->title == $data->title) {
            //         return redirect()->back()->with('error', 'Judul ' . $data->title . ' telah digunakan');
            //     }
            // }

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
    
                    $image_name= "setting/description/" . time().$item.$image_extension;
    
                    Storage::disk('s3')->put($image_name, $imgeDataImg, 'public');
    
                    $image->removeAttribute('src');
    
                    $image->setAttribute('src', 'https://bucket.mareca.my.id/lpsk/'.  $image_name);
                }
            }

            $content = $dom->saveHTML();
            $setting->content = $content;

            if ($data->file('cover')) {
                if ($setting->cover) {
                    Storage::disk('s3')->delete($setting->cover);
                }
                $filename = $data->file('cover')->getClientOriginalName();
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/setting/cover', $file);
                $setting->cover = '/' . $path;
            }
            $setting->slug = str_replace(' ', '-', strtolower($data->document_name));
            $setting->status = $data->status;
            $setting->save();
            return $setting;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllImage($id)
    {
        try {
            $settingImages = SettingImage::where('setting_id', $id)->get();
            foreach ($settingImages as $settingImage) {
                if ($settingImage->url) {
                    Storage::disk('s3')->delete($settingImage->url);
                }
                $settingImage->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $setting = Setting::find($id);
            if ($setting->cover) {
                Storage::disk('s3')->delete($setting->cover);
            }

            // delete image from description summernote
            // $content = $setting->content;
            // $dom = new \DomDocument();
            // $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            // $imageFile = $dom->getElementsByTagName('img');

            // foreach ($imageFile as $item => $image) {
            //     $dataImg = $image->getAttribute('src');
            //     if (Storage::disk('s3')->exists($dataImg)) {
            //         Storage::disk('s3')->delete($dataImg);
            //     }
            // } 

            // delete image
            // $settingImages = SettingImage::where('setting_id', $id)->get();
            // foreach ($settingImages as $settingImage) {
            //     if ($settingImage->url) {
            //         Storage::disk('s3')->delete($settingImage->url);
            //     }
            //     $settingImage->delete();
            // }

            // delete video
            // $settingVideos = SettingVideo::where('setting_id', $id)->get();
            // foreach ($settingVideos as $settingVideo) {
            //     if ($settingVideo->url) {
            //         Storage::disk('s3')->delete($settingVideo->url);
            //     }
            //     $settingVideo->delete();
            // }

            // delete document
            // $settingDocuments = SettingDocument::where('setting_id', $id)->get();
            // foreach ($settingDocuments as $settingDocument) {
            //     if ($settingDocument->url) {
            //         Storage::disk('s3')->delete($settingDocument->url);
            //     }
            //     $settingDocument->delete();
            // }

            $setting->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeImage($data, $id)
    {
        try {
            $setting = Setting::find($id);
            if ($data->file('image')) {
                foreach ($data->file('image') as $key => $image) {
                    $filename = $data->file('image')[$key]->getClientOriginalName();
                    $extension = $data->file('image')[$key]->getClientOriginalExtension();
                    $size = $data->file('image')[$key]->getSize();
                    $url = $data->file('image')[$key];
                    $store = Storage::disk('s3')->put('/setting/images', $url);

                    $settingImage = array(
                        'id' => Str::uuid(),
                        'setting_id' => $setting->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    SettingImage::create($settingImage);
                }
            }

            return $setting;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteImage($id, $image_id)
    {
        try {
            $setting = SettingImage::find($image_id);
            if ($setting->url) {
                Storage::disk('s3')->delete($setting->url);
            }
            $setting->delete();
            return $setting;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateImage($data, $id, $image_id)
    {
        try {
            $setting = SettingImage::find($image_id);
            if ($data->file('image')) {
                if ($setting->url) {
                    Storage::disk('s3')->delete($setting->url);
                }
                $filename = $data->file('image')->getClientOriginalName();
                $extension = $data->file('image')->getClientOriginalExtension();
                $size = $data->file('image')->getSize();
                $setting->name = $filename;
                $setting->extension = $extension;
                $setting->size = $size;
                $file = $data->file('image');
                $path = Storage::disk('s3')->put('/setting/images', $file);
                $setting->url = '/' . $path;
            }
            $setting->save();
            return $setting;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeVideo($data, $id)
    {
        try {
            $setting = Setting::find($id);
            if ($data->file('video')) {
                foreach ($data->file('video') as $key => $video) {
                    $filename = $data->file('video')[$key]->getClientOriginalName();
                    $extension = $data->file('video')[$key]->getClientOriginalExtension();
                    $size = $data->file('video')[$key]->getSize();
                    $url = $data->file('video')[$key];
                    $store = Storage::disk('s3')->put('/setting/videos', $url);

                    $settingVideo = array(
                        'id' => Str::uuid(),
                        'setting_id' => $setting->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    SettingVideo::create($settingVideo);
                }
            }

            return $setting;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteVideo($id, $video_id)
    {
        try {
            $settingVideo = SettingVideo::find($video_id);
            if ($settingVideo->url) {
                Storage::disk('s3')->delete($settingVideo->url);
            }
            $settingVideo->delete();
            return $settingVideo;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateVideo($data, $id, $video_id)
    {
        try {
            $settingVideo = SettingVideo::find($video_id);
            if ($data->file('video')) {
                if ($settingVideo->url) {
                    Storage::disk('s3')->delete($settingVideo->url);
                }
                $filename = $data->file('video')->getClientOriginalName();
                $extension = $data->file('video')->getClientOriginalExtension();
                $size = $data->file('video')->getSize();
                $settingVideo->name = $filename;
                $settingVideo->extension = $extension;
                $settingVideo->size = $size;
                $file = $data->file('video');
                $path = Storage::disk('s3')->put('/setting/videos', $file);
                $settingVideo->url = '/' . $path;
            }
            $settingVideo->save();
            return $settingVideo;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllVideo($id)
    {
        try {
            $settingVideos = SettingVideo::where('setting_id', $id)->get();
            foreach ($settingVideos as $settingVideo) {
                if ($settingVideo->url) {
                    Storage::disk('s3')->delete($settingVideo->url);
                }
                $settingVideo->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeDocument($data, $id)
    {
        try {
            $setting = Setting::find($id);
            if ($data->file('document')) {
                foreach ($data->file('document') as $key => $document) {
                    $filename = $data->file('document')[$key]->getClientOriginalName();
                    $extension = $data->file('document')[$key]->getClientOriginalExtension();
                    $size = $data->file('document')[$key]->getSize();
                    $url = $data->file('document')[$key];
                    $store = Storage::disk('s3')->put('/setting/documents', $url);

                    $settingDocument = array(
                        'id' => Str::uuid(),
                        'setting_id' => $setting->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    SettingDocument::create($settingDocument);
                }
            }

            return $setting;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteDocument($id, $document_id)
    {
        try {
            $settingDocument = SettingDocument::find($document_id);
            if ($settingDocument->url) {
                Storage::disk('s3')->delete($settingDocument->url);
            }
            $settingDocument->delete();
            return $settingDocument;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateDocument($data, $id, $document_id)
    {
        try {
            $settingDocument = SettingDocument::find($document_id);
            if ($data->file('document')) {
                if ($settingDocument->url) {
                    Storage::disk('s3')->delete($settingDocument->url);
                }
                $filename = $data->file('document')->getClientOriginalName();
                $extension = $data->file('document')->getClientOriginalExtension();
                $size = $data->file('document')->getSize();
                $settingDocument->name = $filename;
                $settingDocument->extension = $extension;
                $settingDocument->size = $size;
                $file = $data->file('document');
                $path = Storage::disk('s3')->put('/setting/documents', $file);
                $settingDocument->url = '/' . $path;
            }
            $settingDocument->save();
            return $settingDocument;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllDocument($id)
    {
        try {
            $settingDocuments = SettingDocument::where('setting_id', $id)->get();
            foreach ($settingDocuments as $settingDocument) {
                if ($settingDocument->url) {
                    Storage::disk('s3')->delete($settingDocument->url);
                }
                $settingDocument->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}