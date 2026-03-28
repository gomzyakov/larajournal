<?php

namespace App\Service;

use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * TODO Abolish.
 *
 * @deprecated
 */
class PostService
{
    public function store($data)
    {
        try {
            DB::beginTransaction();

            if (isset($data['tag_ids'])) {
                $tagIds = $data['tag_ids'];
                unset($data['tag_ids']);
            }
            if (isset($data['category_id'])) {
                $categoryId = $data['category_id'];
                unset($data['category_id']);
            }
            if (isset($data['preview_image'])) {
                $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            }
            if (isset($data['main_image'])) {
                $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
            }

            // todo No needs to fix this
            /** @phpstan-ignore-next-line */
            $post = Post::firstOrCreate($data);

            if (isset($tagIds)) {
                $post->tags()->attach($tagIds);
            }
            if (isset($categoryId)) {
                $post->categories()->attach($categoryId);
            }
            DB::commit();
        } catch (Exception) {
            DB::rollBack();
            abort(500);
        }
    }

    public function update($data, $post)
    {
        try {
            DB::beginTransaction();
            if (isset($data['tag_ids'])) {
                $tagIds = $data['tag_ids'];
                unset($data['tag_ids']);
            }
            if (isset($data['preview_image'])) {
                $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            }
            if (isset($data['main_image'])) {
                $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
            }

            $post->update($data);

            if (isset($tagIds)) {
                $post->tags()->sync($tagIds);
            }
            DB::commit();
        } catch (Exception) {
            DB::rollBack();
            abort(500);
        }

        return $post;
    }
}
