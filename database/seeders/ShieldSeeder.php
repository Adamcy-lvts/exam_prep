<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_composite::quiz::session","view_any_composite::quiz::session","create_composite::quiz::session","update_composite::quiz::session","restore_composite::quiz::session","restore_any_composite::quiz::session","replicate_composite::quiz::session","reorder_composite::quiz::session","delete_composite::quiz::session","delete_any_composite::quiz::session","force_delete_composite::quiz::session","force_delete_any_composite::quiz::session","view_course","view_any_course","create_course","update_course","restore_course","restore_any_course","replicate_course","reorder_course","delete_course","delete_any_course","force_delete_course","force_delete_any_course","view_option","view_any_option","create_option","update_option","restore_option","restore_any_option","replicate_option","reorder_option","delete_option","delete_any_option","force_delete_option","force_delete_any_option","view_payment","view_any_payment","create_payment","update_payment","restore_payment","restore_any_payment","replicate_payment","reorder_payment","delete_payment","delete_any_payment","force_delete_payment","force_delete_any_payment","view_plan","view_any_plan","create_plan","update_plan","restore_plan","restore_any_plan","replicate_plan","reorder_plan","delete_plan","delete_any_plan","force_delete_plan","force_delete_any_plan","view_programme","view_any_programme","create_programme","update_programme","restore_programme","restore_any_programme","replicate_programme","reorder_programme","delete_programme","delete_any_programme","force_delete_programme","force_delete_any_programme","view_question","view_any_question","create_question","update_question","restore_question","restore_any_question","replicate_question","reorder_question","delete_question","delete_any_question","force_delete_question","force_delete_any_question","view_quiz","view_any_quiz","create_quiz","update_quiz","restore_quiz","restore_any_quiz","replicate_quiz","reorder_quiz","delete_quiz","delete_any_quiz","force_delete_quiz","force_delete_any_quiz","view_quiz::answer","view_any_quiz::answer","create_quiz::answer","update_quiz::answer","restore_quiz::answer","restore_any_quiz::answer","replicate_quiz::answer","reorder_quiz::answer","delete_quiz::answer","delete_any_quiz::answer","force_delete_quiz::answer","force_delete_any_quiz::answer","view_quiz::attempt","view_any_quiz::attempt","create_quiz::attempt","update_quiz::attempt","restore_quiz::attempt","restore_any_quiz::attempt","replicate_quiz::attempt","reorder_quiz::attempt","delete_quiz::attempt","delete_any_quiz::attempt","force_delete_quiz::attempt","force_delete_any_quiz::attempt","view_quiz::session","view_any_quiz::session","create_quiz::session","update_quiz::session","restore_quiz::session","restore_any_quiz::session","replicate_quiz::session","reorder_quiz::session","delete_quiz::session","delete_any_quiz::session","force_delete_quiz::session","force_delete_any_quiz::session","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_subject","view_any_subject","create_subject","update_subject","restore_subject","restore_any_subject","replicate_subject","reorder_subject","delete_subject","delete_any_subject","force_delete_subject","force_delete_any_subject","view_subscription","view_any_subscription","create_subscription","update_subscription","restore_subscription","restore_any_subscription","replicate_subscription","reorder_subscription","delete_subscription","delete_any_subscription","force_delete_subscription","force_delete_any_subscription","view_topic","view_any_topic","create_topic","update_topic","restore_topic","restore_any_topic","replicate_topic","reorder_topic","delete_topic","delete_any_topic","force_delete_topic","force_delete_any_topic","view_topic::content","view_any_topic::content","create_topic::content","update_topic::content","restore_topic::content","restore_any_topic::content","replicate_topic::content","reorder_topic::content","delete_topic::content","delete_any_topic::content","force_delete_topic::content","force_delete_any_topic::content","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","page_Settings","widget_StatsOverview","widget_UserRegistrationChart"]},{"name":"panel_user","guard_name":"web","permissions":[]}, {"name":"jamb_student","guard_name":"web","permissions":["view_subject","view_any_subject"]},{"name":"noun_student","guard_name":"web","permissions":["view_course","view_any_course"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
