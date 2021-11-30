<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Gallery\{DraftTrait, IndexTrait, RelatedTrait, TagTrait, UserTrait};
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    use IndexTrait, UserTrait, TagTrait, RelatedTrait, DraftTrait;

    protected $galleryTypes = ['index', 'user', 'tag', 'related', 'draft'];

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $id, Request $request)
    {
        $perPage = 30;
        $page = $request->page ?? 1;
        $offset = ($page - 1) * $perPage;
        $parts = explode('_', $id);
        $type = $parts[0];
        $ident = empty($parts[1]) ?: $parts[1];

        if (!in_array($type, $this->galleryTypes)) {
            abort(404);
        }

        $actionName = $type . 'Gallery';

        $works = $this->$actionName($ident, $request);
        if ($works === null) {
            return response('Not found', 404);
        }

        $works->with([
                         'titles' => function ($query) use ($language) {
                             $query->where('language', $language);
                         },
                         'image:id,name,folder',
                         'owners:users.id,old_id,name,username,image_id',
                         'owners.photo'
                     ])->offset($offset)->limit($perPage);

        if ($type !== 'draft') {
            $works->select('works.*')
            ->join('work_titles', function ($join) use ($language) {
                $join->on('work_titles.work_id','=','works.id')->where('work_titles.language', $language);
            })->where('image_id', '!=', 0)->whereNotNull('published_at');
        }
        $users = [];

        switch ($request->order) {
            case 'new':
                $works->orderBy('works.published_at', 'DESC');
                break;
            case 'sale':
                $works->where('price', '>', 0)->orderBy('works.published_at', 'DESC');
                break;
            default:
                $works->where('rating', '>', '20')->orderBy('works.published_at', 'DESC');
        }
        $works = $works->get();
        foreach ($works as &$work) {
            $work->title = sizeof($work->titles) ? $work->titles[0]->title : '';
            $work->old_user_id = $work->image ? $work->image->old_user_id : null;
            $work->unsetRelation('titles');
            $owners = [];
            foreach ($work->owners as $owner) {
                $owner = $owner->toArray();
                if (empty($users[$owner['id']])) {
                    $users[$owner['id']] = $owner;
                    unset($users[$owner['id']]['pivot']);
                }
                if (!in_array($owner['id'], $owners)) {
                    $owners[] = $owner['id'];
                }
            }
            $work->unsetRelation('owners');
            $work->owners = $owners;
        }

        return ['works' => $works, 'users' => $users];
    }

}
