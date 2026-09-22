<?php

namespace App\Repository\Application;

use App\Http\Requests\Application\ApplicationStoreRequest;
use App\Http\Requests\Application\ApplicationUpdateRequest;
use App\Models\Application;
use Illuminate\Pagination\LengthAwarePaginator;

class ApplicationRepository
{
    private const PER_PAGE = 10;

    public function getApplicationsPaginated(): LengthAwarePaginator
    {
        return Application::query()
            ->with(['department', 'user'])
            ->latest()
            ->paginate(self::PER_PAGE);
    }

    public function store(ApplicationStoreRequest $applicationStoreRequest): ?Application
    {
        return Application::create($applicationStoreRequest->validated());
    }

    public function update(ApplicationUpdateRequest $applicationUpdateRequest, Application $application): ?Application
    {
        $application->update($applicationUpdateRequest->validated());

        return $application;
    }

    public function destroy(Application $application): ?bool
    {
        return $application->delete();
    }
}
