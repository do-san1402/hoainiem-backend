<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\NewsMst;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\PostTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Services\PhotoLibraryService;
use Exception;
use Modules\Reporter\Entities\Reporter;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'image' => 'required|image|max:2048',
            'tags' => 'required|string',
            'release_date' => 'required'
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $reporter = Reporter::where([
            'user_id' => $user->id,
        ])->first();

        if ($request->hasFile('image')) {
            $photoLibraryService = new PhotoLibraryService();
            try {
                $photoLibrary = $photoLibraryService->create([
                    'image'     => $request->file('image'),
                    'caption'   => $validated['title'],
                    'reference' => null
                ]);

                $validated['image'] = $photoLibrary->picture_name;
            } catch (Exception $e) {
                return response()->json(['error' => 'Unable to upload image.'], 500);
            }
        }
        $title = $validated['title'];

        $dataNewsMst = [
            'news_id'      => NewsMst::max('id') + 1,
            'encode_title' => Str::slug($title),
            'seo_title'    => $title,
            'stitle'       => $title,
            'title'        => $title,
            'news'         => $validated['description'],
            'image_title'  => $title,
            'image_title'  => $title,
            'page'         => $validated['category'],
            'publish_date' => $validated['release_date'],
            'status'       => 0,
            'reporter'     => null,
            'update_by'    => null,
            'time_stamp'   => time(),
            'post_date'    => Carbon::now(),
            'last_update'  => Carbon::now()->format('Y-m-d h:i:s'),
            'reader_hit'   => 0,
            'reporter_id'  => $reporter->id ?? null,
            'post_by'      => $user->id,
            'image'        => $validated['image'] ?? null,
        ];
       
        $newsMst = NewsMst::create($dataNewsMst);
        $tags = json_decode($validated['tags'], true);

        if (is_array($tags)) {
            $postTags = [];
            foreach ($tags as $tag) {
                $postTags[] = [
                    'news_id' => $newsMst->id,
                    'tag' => $tag,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            PostTag::insert($postTags);
        }
    


        return response()->json([
            'message' => 'Post created successfully!',
            'post' => $newsMst,
        ], 201);
    }
}
