<?php

namespace App\Repositories;

use App\Models\Publication;
use App\Models\User;
use App\Models\UserPublicationRepost;
use App\Models\UserSubscription;
use App\Repositories\Interfaces\IUserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/** Class UserRepository */
class UserRepository implements IUserRepositoryInterface
{
    /**
     * @param int $userId
     * @return null|User
     */
    public function findById(int $userId): ?User
    {
        return User::find($userId);
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getReposts(User $user): Collection
    {
        $reposts_id = UserPublicationRepost::where('user_id', $user->id)->pluck('publication_id');

        return Publication::whereIn('id', $reposts_id)->get();
    }

    /**
     * @return Collection
     */
    public function getSubscriptionRequests(): Collection
    {
        $userId = Auth::id();
        $requests_id = UserSubscription::where('subscribed_to_id', $userId)
            ->where('is_accepted', 0)
            ->pluck('user_id');

        return User::whereIn('id', $requests_id)->get();
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getPublications(User $user): Collection
    {
        return Publication::withTrashed()
            ->where('user_id', $user->id)
            ->with([
                'comments' => function ($query) {
                    $query->orderBy('updated_at', 'desc')->with('user:id,nickname');
                },
            ])
            ->get();
    }

    /**
     * @param string|null $parameter
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function sortUsers(string $parameter = null, string $search = null): LengthAwarePaginator
    {
        $query = User::query();

        $query
            ->where('id', '!=', Auth::id())
            ->where('role', '!=', 'admin');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        $this->applySorting($query, $parameter);

        return $query->paginate(10);
    }

    /**
     * @param string|null $parameter
     * @param string|null $search
     * @param string|null $filter
     * @return LengthAwarePaginator
     */
    public function adminSortUsers(
        string $parameter = null,
        string $search = null,
        string $filter = null,
    ): LengthAwarePaginator {
        $query = User::query();

        if ($filter === 'blocked') {
            $query = User::onlyTrashed();
        } elseif ($filter === 'unblocked') {
            $query->where('role', '!=', 'admin');
        } else {
            $query = User::withTrashed();
        }

        $query
            ->where('id', '!=', Auth::id())
            ->where('role', '!=', 'admin');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('nickname', 'like', "%{$search}%");
            });
        }

        $this->applySorting($query, $parameter);

        return $query->paginate(10);
    }

    /**
     * @param             $query
     * @param null|string $parameter
     * @return void
     */
    protected function applySorting($query, ?string $parameter): void
    {
        [$column, $direction] = $this->parseSortParameter($parameter);
        $query->orderBy($column, $direction);
    }

    /**
     * @param null|string $parameter
     * @return array|string[]
     */
    protected function parseSortParameter(?string $parameter): array
    {
        if ($parameter) {
            $parts = explode(' ', $parameter);
            if (count($parts) === 2 && in_array(strtolower($parts[1]), ['asc', 'desc'])) {
                return [$parts[0], $parts[1]];
            }
        }
        return ['updated_at', 'desc'];
    }

    /**
     * @param int   $userId
     * @param array $data
     * @return bool
     */
    public function update(int $userId, array $data): bool
    {
        return User::where('id', $userId)->update($data);
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function delete(int $userId): bool
    {
        $user = $this->findById($userId);
        if ($user) {
            return $user->delete();
        }
        return false;
    }
}