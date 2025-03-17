<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;
    use HasUuids;

    // protected $primaryKey = '';


    protected $fillable = [
        'name',
        'guard_name',
    ];

    // public function users()
    // {
    //     return $this->belongsTo(User::class);
    // }


    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }

}
