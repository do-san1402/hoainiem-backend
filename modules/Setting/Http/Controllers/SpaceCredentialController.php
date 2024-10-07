<?php
namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Setting\DataTables\SpaceCredentialDataTable;
use Modules\Setting\Http\Requests\SpaceCredentialRequest;
use Modules\Setting\Services\SpaceCredentialService;

class SpaceCredentialController extends Controller
{
    /**
     * Controller constructor
     *
     * @param SpaceCredentialService $spaceCredentialService
     */
    public function __construct(protected SpaceCredentialService $spaceCredentialService)
    {
        $this->middleware('permission:read_space_credential')->only(['index']);
        $this->middleware('permission:create_space_credential')->only(['store']);
        $this->middleware('permission:update_space_credential')->only(['edit', 'update', 'updateStatus']);
        $this->middleware('permission:delete_space_credential')->only(['destroy']);
        $this->middleware(['demo'])->only(['store', 'updateStatus', 'destroy', 'update']);
    }

    /**
     * Display a listing of the resource.
     * @param SpaceCredentialDataTable $dataTable
     * @return Renderable
     *
     */
    public function index(SpaceCredentialDataTable $dataTable)
    {
        return $dataTable->render('setting::space-credential.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SpaceCredentialRequest $request
     * @return JsonResponse
     */
    public function store(SpaceCredentialRequest $request): JsonResponse
    {
        $data = $request->validated();

        $spaceCredential = $this->spaceCredentialService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("space_credential_create_successfully"),
            'title'   => localize("space_credential"),
            'data'    => $spaceCredential,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(int $id): JsonResponse
    {
        $spaceCredential = $this->spaceCredentialService->spaceCredentialData($id);

        return response()->json([
            'success' => true,
            'message' => localize("space_credential_data"),
            'title'   => localize("space_credential"),
            'data'    => $spaceCredential,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SpaceCredentialRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(SpaceCredentialRequest $request, int $id): JsonResponse
    {
        $data        = $request->validated();
        $data['id']  = $id;
        $updateCheck = $this->spaceCredentialService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("space_credential_update_successfully"),
            'title'   => localize("space_credential"),
            'data'    => $updateCheck,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->spaceCredentialService->destroy(['id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("space_credential_data_delete_successfully"),
            'title'   => localize("space_credential"),
        ]);
    }

    /**
     * Update status
     *
     * @param UpdateStatusRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function updateStatus(UpdateStatusRequest $request, int $id): JsonResponse
    {
        $data        = $request->validated();
        $data['id']  = $id;
        $status_span = $this->spaceCredentialService->updateStatus($data);

        return response()->json([
            'success' => true,
            'message' => localize("space_credential_update_status_successfully"),
            'title'   => localize("space_credential"),
            'data'    => $status_span,
        ]);
    }
}
