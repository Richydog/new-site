<?php


namespace App\UseCases\Adverts;
use App\Advert;
use App\Model\Adverts\Category;
use App\Model\Region;
use App\User;
use App\Http\Requests\Adverts\CreateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use  App\Http\Requests\Adverts\PhotosRequest;
use App\Http\Requests\Adverts\RejectRequest;
use App\Http\Requests\Adverts\AttributesRequest;
use App\Http\Requests\Adverts\EditRequest;
class AdvertService
{
    public function create($userId, $categoryId, $regionId, CreateRequest $request): Advert
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        /** @var Category $category */
        $category = Category::findOrFail($categoryId);
        /** @var Region $region */
        $region = $regionId ? Region::findOrFail($regionId) : null;

        return DB::transaction(function () use ($request, $user, $category, $region) {

            /** @var Advert $advert */
            $advert = Advert::make([
                'title' => $request['title'],
                'content' => $request['content'],
                'price' => $request['price'],
                'address' => $request['address'],
                'status' => Advert::STATUS_DRAFT,
            ]);

            $advert->user()->associate($user);
            $advert->category()->associate($category);
            $advert->region()->associate($region);

            $advert->saveOrFail();

            foreach ($category->allAttributes() as $attribute) {
                $value = $request['attributes'][$attribute->id] ?? null;
                if (!empty($value)) {
                    $advert->values()->create([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                    ]);
                }
            }

            return $advert;
        });
    }

    public function addPhotos($id, PhotosRequest $request): void
    {
        $advert = $this->getAdvert($id);

        DB::transaction(function () use ($request, $advert) {
            foreach ($request['files'] as $file) {
                $advert->photos()->create([
                    'file' => $file->store('adverts', 'public')
                ]);
            }
            $advert->update();
        });
    }

    public function edit($id, EditRequest $request): void
    {
        $advert = $this->getAdvert($id);
        $advert->update($request->only([
            'title',
            'content',
            'price',
            'address',
        ]));
    }

    private function getAdvert($id): Advert
    {
        return Advert::findOrFail($id);
    }

    public function sendToModeration($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->sendToModeration();
    }
    public function moderate($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->moderate(Carbon::now());
       // event(new ModerationPassed($advert));
    }

    public function reject($id, RejectRequest $request): void
    {
        $advert = $this->getAdvert($id);
        $advert->reject($request['reason']);
    }
    public function editAttributes($id, AttributesRequest $request): void
    {
        $advert = $this->getAdvert($id);

        DB::transaction(function () use ($request, $advert) {
            $advert->values()->delete();
            foreach ($advert->category->allAttributes() as $attribute) {
                $value = $request['attributes'][$attribute->id] ?? null;
                if (!empty($value)) {
                    $advert->values()->create([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                    ]);
                }
            }
            $advert->update();
        });
    }
    public function remove($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->delete();
    }
    public function expire(Advert $advert): void
    {
        $advert->expire();
    }
    public function close($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->close();
    }
}