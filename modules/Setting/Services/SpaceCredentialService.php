<?php

namespace Modules\Setting\Services;

use App\Models\SpaceCredential;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class SpaceCredentialService
{
    /**
     * Create
     *
     * @param  array  $attributes
     * @return SpaceCredential
     * @throws Exception
     */
    public function create(array $attributes): SpaceCredential
    {
        try {
            DB::beginTransaction();

            $insertData = [
                'key'    => $attributes['key'],
                'secret' => $attributes['secret'],
                'region' => $attributes['region'],
                'bucket' => $attributes['bucket'],
                'url'    => $attributes['url'],
            ];

            $spaceCredential = SpaceCredential::create($insertData);

            DB::commit();

            return $spaceCredential;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("space_credential_create_error"),
                'title'   => localize("space_credential"),
            ], 422));
        }

    }

    /**
     * Update
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $spaceCredentialId = $attributes['id'];

        try {
            DB::beginTransaction();

            $spaceCredential = SpaceCredential::findOrFail($spaceCredentialId);

            $updateData = [
                'key'    => $attributes['key'],
                'secret' => $attributes['secret'],
                'region' => $attributes['region'],
                'bucket' => $attributes['bucket'],
                'url'    => $attributes['url'],
            ];

            $spaceCredential = $spaceCredential->update($updateData);

            DB::commit();

            return true;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("space_credential_update_error"),
                'title'   => localize("space_credential"),
            ], 422));
        }

    }

    /**
     * Delete
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $spaceCredentialId = $attributes['id'];

        try {
            DB::beginTransaction();

            SpaceCredential::where('id', $spaceCredentialId)->delete();

            DB::commit();

            return true;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("space_credential_delete_error"),
                'title'   => localize("space_credential"),
            ], 422));
        }

    }

    /**
     * SpaceCredential data
     *
     * @param integer $id
     * @return SpaceCredential|null
     */
    public function spaceCredentialData(int $id): ?SpaceCredential
    {
        $spaceCredential = SpaceCredential::findOrFail($id);

        return $spaceCredential;
    }

    /**
     * Update Status
     *
     * @param  array  $attributes
     * @return string
     * @throws Exception
     */
    public function updateStatus(array $attributes): string
    {
        $spaceCredentialId = $attributes['id'];
        $spaceCredential           = SpaceCredential::findOrFail($spaceCredentialId);

        try {
            DB::beginTransaction();

            $status = $attributes['status'] ?? 0;

            $spaceCredentialData = [
                'status' => $status,
            ];

            $spaceCredential->update($spaceCredentialData);
            $spaceCredential->refresh();

            DB::commit();

            $status_span = "";

            if ($spaceCredential->status == 1) {
                $status_span = '<span class="btn btn-labeled btn-success mb-2 mr-1 update-status-button" title="' . localize('publish') . '" data-action="' . route('space-credential.update-status', ['space_credential' => $spaceCredential->id]) . '" data-update_status="0" >' . localize('publish') . '</span>';

            } else {
                $status_span = '<span class="btn btn-labeled btn-warning mb-2 mr-1 update-status-button" title="' . localize('unpublish') . '" data-action="' . route('space-credential.update-status', ['space_credential' => $spaceCredential->id]) . '" data-update_status="1" >' . localize('unpublish') . '</span>';

            }

            return $status_span;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("space_credential_update_status_error"),
                'title'   => localize("space_credential"),
            ], 422));
        }

    }

}
