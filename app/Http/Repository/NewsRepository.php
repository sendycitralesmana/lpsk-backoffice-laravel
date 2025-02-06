<?php

namespace App\Http\Repository;

use App\Models\News;
use App\Models\NewsDocument;
use App\Models\NewsImage;
use App\Models\NewsVideo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $news = News::with(['user:id,name,email,created_at,updated_at', 'documents', 'images', 'videos'])->orderBy('created_at', 'desc')->where('status', 'DINAIKAN');

            if ($request->search) {
                $news->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->category_id) {
                $news->where('news_category_id', $request->category_id);
            }

            if ($request->user_id) {
                $news->where('user_id', $request->user_id);
            }

            if ($request->status) {
                $news->where('status', $request->status);
            }

            if ($request->category_slug) {   
                $news->whereHas('newsCategory', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }

            if ($request->cover) {
                $news->where('cover', $request->cover);
                // $news->where('cover', 'like', '%' . $request->cover . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $news->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $news = $news->paginate($per_page);

            return $news;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // getLatestApi
    public function getLatestArtikelApi()
    {
        try {
            return News::orderBy('created_at', 'desc')->where('status', 'DINAIKAN')->whereHas('newsCategory', function ($query) {
                $query->where('slug', 'artikel');
            })->limit(4)->get();


        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getLatestInformasiApi()
    {
        try {
            return News::orderBy('created_at', 'desc')->where('status', 'DINAIKAN')->whereHas('newsCategory', function ($query) {
                $query->where('slug', 'informasi');
            })->limit(4)->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllNoPaginate($data)
    {
        try {
            
            if (Auth::user()->role_id == 1) {
                return News::orderBy('created_at', 'desc')->where('status', 'DINAIKAN')->get();
            } else {
                return News::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->where('status', 'DINAIKAN')->get();
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll($data)
    {
        try {

            $news = News::orderBy('created_at', 'desc');

            if ($data->search) {
                $news->where('title', 'like', '%' . $data->search . '%');
            }

            if ($data->category_id) {
                $news->where('news_category_id', $data->category_id);
            }

            if ($data->user_id) {
                $news->where('user_id', $data->user_id);
            }

            if ($data->status) {
                $news->where('status', $data->status);
            }

            if (Auth::user()->role_id == 1) {
                return $news->paginate(12);
            } else {
                return $news->where('user_id', Auth::user()->id)->paginate(12);
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return News::with(['user:id,name,email,created_at,updated_at'])->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {

        DB::beginTransaction();

        try {
            $news = new News();
            $news->id = Str::uuid();
            $news->user_id = Auth::user()->id;
            $news->news_category_id = $data->news_category_id;
            $news->title = $data->title;
            // $news->content = $data->content;

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

                $image_name= "news/description/" . time().$item.$image_extension;

                Storage::disk('s3')->put($image_name, $imgeDataImg, 'public');

                $image->removeAttribute('src');

                $image->setAttribute('src', 'https://bucket.mareca.my.id/lpsk/'.  $image_name);
            }

            $content = $dom->saveHTML();
            $news->content = $content;

            if ($data->file('cover')) {
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/news/cover', $file);
                $news->cover = '/' . $path;
            }

            if (Auth::user()->role_id == 1) {
                $news->status = "DINAIKAN";
            } else {
                $news->status = "DIAJUKAN";
            }

            $news->save();

            // insert image
            if ($data->file('image')) {
                foreach ($data->file('image') as $key => $image) {
                    $filename = $data->file('image')[$key]->getClientOriginalName();
                    $extension = $data->file('image')[$key]->getClientOriginalExtension();
                    $size = $data->file('image')[$key]->getSize();
                    $url = $data->file('image')[$key];
                    $store = Storage::disk('s3')->put('/news/images', $url);

                    $newsImage = array(
                        'id' => Str::uuid(),
                        'news_id' => $news->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    NewsImage::create($newsImage);
                }
            }

            // insert video
            if ($data->file('video')) {
                foreach ($data->file('video') as $key => $video) {
                    $filename = $data->file('video')[$key]->getClientOriginalName();
                    $extension = $data->file('video')[$key]->getClientOriginalExtension();
                    $size = $data->file('video')[$key]->getSize();
                    $url = $data->file('video')[$key];
                    $store = Storage::disk('s3')->put('/news/videos', $url);

                    $newsVideo = array(
                        'id' => Str::uuid(),
                        'news_id' => $news->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $url,
                    );
                    NewsVideo::create($newsVideo);
                }
            }

            // insert document
            if ($data->file('document')) {
                foreach ($data->file('document') as $key => $document) {
                    $filename = $data->file('document')[$key]->getClientOriginalName();
                    $extension = $data->file('document')[$key]->getClientOriginalExtension();
                    $size = $data->file('document')[$key]->getSize();
                    $url = $data->file('document')[$key];
                    $store = Storage::disk('s3')->put('/news/documents', $url);

                    $newsDocument = array(
                        'id' => Str::uuid(),
                        'news_id' => $news->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $url,
                    );
                    NewsDocument::create($newsDocument);
                }
            }

            DB::commit();

            return $news;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $newss = News::where('id', '!=', $id)->get();
            $news = News::find($id);
            $news->news_category_id = $data->news_category_id;
            // foreach ($newss as $news) {
            //     if ($news->title == $data->title) {
            //         return redirect()->back()->with('error', 'Judul ' . $data->title . ' telah digunakan');
            //     }
            // }
            if ($data->file('cover')) {
                if ($news->cover) {
                    Storage::disk('s3')->delete($news->cover);
                }
                $filename = $data->file('cover')->getClientOriginalName();
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/news/cover', $file);
                $news->cover = '/' . $path;
            }

            // start content
            // $news->content = $data->content;
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
    
                    $image_name= "news/description/" . time().$item.$image_extension;
    
                    Storage::disk('s3')->put($image_name, $imgeDataImg, 'public');
    
                    $image->removeAttribute('src');
    
                    $image->setAttribute('src', 'https://bucket.mareca.my.id/lpsk/'.  $image_name);
                }
            }

            $content = $dom->saveHTML();
            $news->content = $content;
            // end content

            $news->slug = str_replace(' ', '-', strtolower($data->document_name));
            $news->status = $data->status;
            $news->save();
            return $news;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllImage($id)
    {
        try {
            $newsImages = NewsImage::where('news_id', $id)->get();
            foreach ($newsImages as $newsImage) {
                if ($newsImage->url) {
                    Storage::disk('s3')->delete($newsImage->url);
                }
                $newsImage->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $news = News::find($id);
            if ($news->cover) {
                Storage::disk('s3')->delete($news->cover);
            }

            // delete image from description summernote
            // $dom = new \DomDocument();
            // $dom->loadHtml($news->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            // $imageFile = $dom->getElementsByTagName('img');
            // foreach ($imageFile as $item => $image) {
            //     $path = $image->getAttribute('src');
            //     if (Storage::disk('s3')->exists($path)) {
            //         Storage::disk('s3')->delete($path);
            //     }
            // }

            // delete image
            // $newsImages = NewsImage::where('news_id', $id)->get();
            // foreach ($newsImages as $newsImage) {
            //     if ($newsImage->url) {
            //         Storage::disk('s3')->delete($newsImage->url);
            //     }
            //     $newsImage->delete();
            // }

            // delete video
            // $newsVideos = NewsVideo::where('news_id', $id)->get();
            // foreach ($newsVideos as $newsVideo) {
            //     if ($newsVideo->url) {
            //         Storage::disk('s3')->delete($newsVideo->url);
            //     }
            //     $newsVideo->delete();
            // }

            // delete document
            // $newsDocuments = NewsDocument::where('news_id', $id)->get();
            // foreach ($newsDocuments as $newsDocument) {
            //     if ($newsDocument->url) {
            //         Storage::disk('s3')->delete($newsDocument->url);
            //     }
            //     $newsDocument->delete();
            // }

            $news->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeImage($data, $id)
    {
        try {
            $news = News::find($id);
            if ($data->file('image')) {
                foreach ($data->file('image') as $key => $image) {
                    $filename = $data->file('image')[$key]->getClientOriginalName();
                    $extension = $data->file('image')[$key]->getClientOriginalExtension();
                    $size = $data->file('image')[$key]->getSize();
                    $url = $data->file('image')[$key];
                    $store = Storage::disk('s3')->put('news/images', $url);

                    $newsImage = array(
                        'id' => Str::uuid(),
                        'news_id' => $news->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    NewsImage::create($newsImage);
                }
            }

            return $news;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteImage($id, $image_id)
    {
        try {
            $news = NewsImage::find($image_id);
            if ($news->url) {
                Storage::disk('s3')->delete($news->url);
            }
            $news->delete();
            return $news;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateImage($data, $id, $image_id)
    {
        try {
            $news = NewsImage::find($image_id);
            if ($data->file('image')) {
                if ($news->url) {
                    Storage::disk('s3')->delete($news->url);
                }
                $filename = $data->file('image')->getClientOriginalName();
                $extension = $data->file('image')->getClientOriginalExtension();
                $size = $data->file('image')->getSize();
                $news->name = $filename;
                $news->extension = $extension;
                $news->size = $size;
                $file = $data->file('image');
                $path = Storage::disk('s3')->put('/news/images', $file);
                $news->url = '/' . $path;
            }
            $news->save();
            return $news;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeVideo($data, $id)
    {
        try {
            $news = News::find($id);
            if ($data->file('video')) {
                foreach ($data->file('video') as $key => $video) {
                    $filename = $data->file('video')[$key]->getClientOriginalName();
                    $extension = $data->file('video')[$key]->getClientOriginalExtension();
                    $size = $data->file('video')[$key]->getSize();
                    $url = $data->file('video')[$key];
                    $store = Storage::disk('s3')->put('/news/videos', $url);

                    $newsVideo = array(
                        'id' => Str::uuid(),
                        'news_id' => $news->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    NewsVideo::create($newsVideo);
                }
            }

            return $news;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteVideo($id, $video_id)
    {
        try {
            $newsVideo = NewsVideo::find($video_id);
            if ($newsVideo->url) {
                Storage::disk('s3')->delete($newsVideo->url);
            }
            $newsVideo->delete();
            return $newsVideo;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateVideo($data, $id, $video_id)
    {
        try {
            $newsVideo = NewsVideo::find($video_id);
            if ($data->file('video')) {
                if ($newsVideo->url) {
                    Storage::disk('s3')->delete($newsVideo->url);
                }
                $filename = $data->file('video')->getClientOriginalName();
                $extension = $data->file('video')->getClientOriginalExtension();
                $size = $data->file('video')->getSize();
                $newsVideo->name = $filename;
                $newsVideo->extension = $extension;
                $newsVideo->size = $size;
                $file = $data->file('video');
                $path = Storage::disk('s3')->put('/news/videos', $file);
                $newsVideo->url = '/' . $path;
            }
            $newsVideo->save();
            return $newsVideo;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllVideo($id)
    {
        try {
            $newsVideos = NewsVideo::where('news_id', $id)->get();
            foreach ($newsVideos as $newsVideo) {
                if ($newsVideo->url) {
                    Storage::disk('s3')->delete($newsVideo->url);
                }
                $newsVideo->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeDocument($data, $id)
    {
        try {
            $news = News::find($id);
            if ($data->file('document')) {
                foreach ($data->file('document') as $key => $document) {
                    $filename = $data->file('document')[$key]->getClientOriginalName();
                    $extension = $data->file('document')[$key]->getClientOriginalExtension();
                    $size = $data->file('document')[$key]->getSize();
                    $url = $data->file('document')[$key];
                    $store = Storage::disk('s3')->put('/news/documents', $url);

                    $newsDocument = array(
                        'id' => Str::uuid(),
                        'news_id' => $news->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => '/' . $store,
                    );
                    NewsDocument::create($newsDocument);
                }
            }

            return $news;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteDocument($id, $document_id)
    {
        try {
            $newsDocument = NewsDocument::find($document_id);
            if ($newsDocument->url) {
                Storage::disk('s3')->delete($newsDocument->url);
            }
            $newsDocument->delete();
            return $newsDocument;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateDocument($data, $id, $document_id)
    {
        try {
            $newsDocument = NewsDocument::find($document_id);
            if ($data->file('document')) {
                if ($newsDocument->url) {
                    Storage::disk('s3')->delete($newsDocument->url);
                }
                $filename = $data->file('document')->getClientOriginalName();
                $extension = $data->file('document')->getClientOriginalExtension();
                $size = $data->file('document')->getSize();
                $newsDocument->name = $filename;
                $newsDocument->extension = $extension;
                $newsDocument->size = $size;
                $file = $data->file('document');
                $path = Storage::disk('s3')->put('/news/documents', $file);
                $newsDocument->url = '/' . $path;
            }
            $newsDocument->save();
            return $newsDocument;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllDocument($id)
    {
        try {
            $newsDocuments = NewsDocument::where('news_id', $id)->get();
            foreach ($newsDocuments as $newsDocument) {
                if ($newsDocument->url) {
                    Storage::disk('s3')->delete($newsDocument->url);
                }
                $newsDocument->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}