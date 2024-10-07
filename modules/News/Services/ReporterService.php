<?php

namespace Modules\News\Services;

use App\Helpers\ImageHelper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Reporter\Entities\Reporter;

class ReporterService
{
    /**
     * Create Reporter
     *
     * @param  array  $attributes
     * @return Reporter
     * @throws Exception
     */
    public function create(array $attributes)
    {
        try {
            DB::beginTransaction();
            $photoUpload = ImageHelper::upload($attributes['photo'] ?? null, 'uploads/reporter');
            $photoPath   = $photoUpload['image_path'] ?? null;

            $insertUserData = [
                'user_type_id' => 2,
                'user_name'    => strtolower($attributes['name']),
                'full_name'    => strtolower($attributes['name']),
                'password'     => bcrypt(1234568),
                'is_active'    => true,
            ];
            $user = User::create($insertUserData);

            $user->assignRole(2);

            $insertReporterData = [
                'photo'       => $photoPath,
                'name'        => $attributes['name'],
                'designation' => $attributes['designation'],
                'user_id'     => $user->id,
                'status'      => 1,
            ];
            $reporter = Reporter::create($insertReporterData);

            DB::commit();

            return $reporter;

        } catch (Exception $exception) {

            DB::rollBack();

            throw $exception;
        }

    }

}
