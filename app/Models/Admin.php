<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Set the default guard for this model.
     *
     * @var string
     */
    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Superadmin can see all data.
     * Admin can manage managers.
     * Managers can manage employees.
     * Employees see only their own data.
     */

    // Relationship: Admin (Superadmin) has many Admins (Managers)
    public function subAdmins()
    {
        return $this->hasMany(Admin::class, 'parent_id');
    }

    // Relationship: An Admin (Manager) has many Employees
    public function employees()
    {
        return $this->hasMany(Admin::class, 'parent_id')->whereHas('roles', function ($query) {
            $query->where('name', 'employee');
        });
    }

    // Relationship: Each Admin has a Parent (who created/assigned them)
    public function parent()
    {
        return $this->belongsTo(Admin::class, 'parent_id');
    }

    // Check if the user is Super Admin
    public function isSuperAdmin()
    {
        return $this->hasRole('superadmin');
    }

    // Check if the user is Admin
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    // Check if the user is Manager
    public function isManager()
    {
        return $this->hasRole('manager');
    }

    // Check if the user is Employee
    public function isEmployee()
    {
        return $this->hasRole('employee');
    }
    public function createdUsers()
    {
        return $this->hasMany(Admin::class, 'created_by');
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public static function getpermissionGroups()
    {
        $permission_groups = DB::table('permissions')
            ->select('group_name as name')
            ->groupBy('group_name')
            ->get();
        return $permission_groups;
    }

    public static function getpermissionsByGroupName($group_name)
    {
        $permissions = DB::table('permissions')
            ->select('name', 'id')
            ->where('group_name', $group_name)
            ->get();
        return $permissions;
    }

    public static function roleHasPermissions($role, $permissions)
    {
        $hasPermission = true;
        foreach ($permissions as $permission) {
            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }
        }
        return $hasPermission;
    }
}
