<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Gallery\{DraftTrait, IndexTrait, RelatedTrait, TagTrait, UserTrait};
use App\User;
use Clockwork\Request\Log;
use Facade\FlareClient\Http\Exceptions\NotFound;
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

        $works = $this->$actionName($ident, $request)->with(['titles' => function ($query) use ($language) {
            $query->where('language', $language);
        }, 'image:id,name,folder', 'owners:users.id,old_id,name,username', 'owners.photo'])->offset($offset)->limit($perPage);

        if ($type !== 'draft') {
            $works = $works->whereHas('titles', function ($query) use ($language) {
                $query->where('language', $language);
            })->whereHas('image')->whereNotNull('published_at');
        }
        $users = [];

        switch ($request->order){
            case 'new':
                $works = $works->orderBy('created_at', 'DESC');
                break;
            case 'sale':
                $works = $works->where('price', '>', 0)->orderBy('created_at', 'DESC');
                break;
            default:
                $works = $works->where('rating', '>', '20')->orderBy('created_at', 'DESC');
        }
        $works=$works->get();

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
