<?php

namespace App\Http\Repository;

use App\Models\RoadMap;
use App\Models\RoadMapDocuments;
use App\Models\RoadMapImages;
use App\Models\RoadMapVideos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoadMapRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $roadmap = RoadMap::orderBy('created_at', 'desc');

            if ($request->search) {
                $roadmap->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->category_id) {
                $roadmap->where('roadmap_category_id', $request->category_id);
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $roadmap->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $roadmap = $roadmap->paginate($per_page);

            return $roadmap;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return RoadMap::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return RoadMap::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $roadmap = new RoadMap();
            $roadmap->user_id = Auth::user()->id;
            $roadmap->title = $data->title;
            $roadmap->content = $data->content;
            if ($data->file('cover')) {
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/roadmap/cover', $file);
                $roadmap->cover = $path;
            }
            $roadmap->save();

            // insert image
            if ($data->file('image')) {
                foreach ($data->file('image') as $key => $image) {
                    $filename = $data->file('image')[$key]->getClientOriginalName();
                    $extension = $data->file('image')[$key]->getClientOriginalExtension();
                    $size = $data->file('image')[$key]->getSize();
                    $url = $data->file('image')[$key];
                    $store = Storage::disk('s3')->put('/roadmap/images', $url);

                    $roadmapImage = array(
                        'roadmap_id' => $roadmap->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => $store,
                    );
                    RoadMapImages::create($roadmapImage);
                }
            }

            // insert video
            if ($data->file('video')) {
                foreach ($data->file('video') as $key => $video) {
                    $filename = $data->file('video')[$key]->getClientOriginalName();
                    $extension = $data->file('video')[$key]->getClientOriginalExtension();
                    $size = $data->file('video')[$key]->getSize();
                    $url = $data->file('video')[$key];
                    $store = Storage::disk('s3')->put('/roadmap/videos', $url);

                    $roadmapVideo = array(
                        'roadmap_id' => $roadmap->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => $url,
                    );
                    RoadMapVideos::create($roadmapVideo);
                }
            }

            // insert document
            if ($data->file('document')) {
                foreach ($data->file('document') as $key => $document) {
                    $filename = $data->file('document')[$key]->getClientOriginalName();
                    $extension = $data->file('document')[$key]->getClientOriginalExtension();
                    $size = $data->file('document')[$key]->getSize();
                    $url = $data->file('document')[$key];
                    $store = Storage::disk('s3')->put('/roadmap/documents', $url);

                    $roadmapDocument = array(
                        'roadmap_id' => $roadmap->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => $url,
                    );
                    RoadMapDocuments::create($roadmapDocument);
                }
            }

            DB::commit();

            return $roadmap;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $roadmaps = RoadMap::where('id', '!=', $id)->get();
            $roadmap = RoadMap::find($id);
            // foreach ($roadmaps as $roadmap) {
            //     if ($roadmap->title == $data->title) {
            //         return redirect()->back()->with('error', 'Judul ' . $data->title . ' telah digunakan');
            //     }
            // }
            $roadmap->title = $data->title;
            $roadmap->content = $data->content;
            if ($data->file('cover')) {
                if ($roadmap->cover) {
                    Storage::disk('s3')->delete($roadmap->cover);
                }
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/roadmap/covers', $file);
                $roadmap->cover = $path;
            }
            $roadmap->slug = str_replace(' ', '-', strtolower($data->document_name));
            $roadmap->save();
            return $roadmap;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllImage($id)
    {
        try {
            $roadmapImages = RoadMapImages::where('roadmap_id', $id)->get();
            foreach ($roadmapImages as $roadmapImage) {
                if ($roadmapImage->url) {
                    Storage::disk('s3')->delete($roadmapImage->url);
                }
                $roadmapImage->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $roadmap = RoadMap::find($id);
            if ($roadmap->cover) {
                Storage::disk('s3')->delete($roadmap->cover);
            }
            $roadmap->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeImage($data, $id)
    {
        try {
            $roadmap = RoadMap::find($id);
            if ($data->file('image')) {
                foreach ($data->file('image') as $key => $image) {
                    $filename = $data->file('image')[$key]->getClientOriginalName();
                    $extension = $data->file('image')[$key]->getClientOriginalExtension();
                    $size = $data->file('image')[$key]->getSize();
                    $url = $data->file('image')[$key];
                    $store = Storage::disk('s3')->put('/roadmap/images', $url);

                    $roadmapImage = array(
                        'roadmap_id' => $roadmap->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => $store,
                    );
                    RoadMapImages::create($roadmapImage);
                }
            }

            return $roadmap;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteImage($id, $image_id)
    {
        try {
            $roadmap = RoadMapImages::find($image_id);
            if ($roadmap->url) {
                Storage::disk('s3')->delete($roadmap->url);
            }
            $roadmap->delete();
            return $roadmap;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateImage($data, $id, $image_id)
    {
        try {
            $roadmap = RoadMapImages::find($image_id);
            if ($data->file('image')) {
                if ($roadmap->url) {
                    Storage::disk('s3')->delete($roadmap->url);
                }
                $filename = $data->file('image')->getClientOriginalName();
                $extension = $data->file('image')->getClientOriginalExtension();
                $size = $data->file('image')->getSize();
                $roadmap->name = $filename;
                $roadmap->extension = $extension;
                $roadmap->size = $size;
                $file = $data->file('image');
                $path = Storage::disk('s3')->put('/roadmap/images', $file);
                $roadmap->url = $path;
            }
            $roadmap->save();
            return $roadmap;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeVideo($data, $id)
    {
        try {
            $roadmap = RoadMap::find($id);
            if ($data->file('video')) {
                foreach ($data->file('video') as $key => $video) {
                    $filename = $data->file('video')[$key]->getClientOriginalName();
                    $extension = $data->file('video')[$key]->getClientOriginalExtension();
                    $size = $data->file('video')[$key]->getSize();
                    $url = $data->file('video')[$key];
                    $store = Storage::disk('s3')->put('/roadmap/videos', $url);

                    $roadmapVideo = array(
                        'roadmap_id' => $roadmap->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => $store,
                    );
                    RoadMapVideos::create($roadmapVideo);
                }
            }

            return $roadmap;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteVideo($id, $video_id)
    {
        try {
            $roadmapVideo = RoadMapVideos::find($video_id);
            if ($roadmapVideo->url) {
                Storage::disk('s3')->delete($roadmapVideo->url);
            }
            $roadmapVideo->delete();
            return $roadmapVideo;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateVideo($data, $id, $video_id)
    {
        try {
            $roadmapVideo = RoadMapVideos::find($video_id);
            if ($data->file('video')) {
                if ($roadmapVideo->url) {
                    Storage::disk('s3')->delete($roadmapVideo->url);
                }
                $filename = $data->file('video')->getClientOriginalName();
                $extension = $data->file('video')->getClientOriginalExtension();
                $size = $data->file('video')->getSize();
                $roadmapVideo->name = $filename;
                $roadmapVideo->extension = $extension;
                $roadmapVideo->size = $size;
                $file = $data->file('video');
                $path = Storage::disk('s3')->put('/roadmap/videos', $file);
                $roadmapVideo->url = $path;
            }
            $roadmapVideo->save();
            return $roadmapVideo;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllVideo($id)
    {
        try {
            $roadmapVideos = RoadMapVideos::where('roadmap_id', $id)->get();
            foreach ($roadmapVideos as $roadmapVideo) {
                if ($roadmapVideo->url) {
                    Storage::disk('s3')->delete($roadmapVideo->url);
                }
                $roadmapVideo->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeDocument($data, $id)
    {
        try {
            $roadmap = RoadMap::find($id);
            if ($data->file('document')) {
                foreach ($data->file('document') as $key => $document) {
                    $filename = $data->file('document')[$key]->getClientOriginalName();
                    $extension = $data->file('document')[$key]->getClientOriginalExtension();
                    $size = $data->file('document')[$key]->getSize();
                    $url = $data->file('document')[$key];
                    $store = Storage::disk('s3')->put('/roadmap/documents', $url);

                    $roadmapDocument = array(
                        'roadmap_id' => $roadmap->id,
                        'name' => $filename,
                        'extension' => $extension,
                        'size' => $size,
                        'url' => $store,
                    );
                    RoadMapDocuments::create($roadmapDocument);
                }
            }

            return $roadmap;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteDocument($id, $document_id)
    {
        try {
            $roadmapDocument = RoadMapDocuments::find($document_id);
            if ($roadmapDocument->url) {
                Storage::disk('s3')->delete($roadmapDocument->url);
            }
            $roadmapDocument->delete();
            return $roadmapDocument;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateDocument($data, $id, $document_id)
    {
        try {
            $roadmapDocument = RoadMapDocuments::find($document_id);
            if ($data->file('document')) {
                if ($roadmapDocument->url) {
                    Storage::disk('s3')->delete($roadmapDocument->url);
                }
                $filename = $data->file('document')->getClientOriginalName();
                $extension = $data->file('document')->getClientOriginalExtension();
                $size = $data->file('document')->getSize();
                $roadmapDocument->name = $filename;
                $roadmapDocument->extension = $extension;
                $roadmapDocument->size = $size;
                $file = $data->file('document');
                $path = Storage::disk('s3')->put('/roadmap/documents', $file);
                $roadmapDocument->url = $path;
            }
            $roadmapDocument->save();
            return $roadmapDocument;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteAllDocument($id)
    {
        try {
            $roadmapDocuments = RoadMapDocuments::where('roadmap_id', $id)->get();
            foreach ($roadmapDocuments as $roadmapDocument) {
                if ($roadmapDocument->url) {
                    Storage::disk('s3')->delete($roadmapDocument->url);
                }
                $roadmapDocument->delete();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}