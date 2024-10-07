<?php

namespace Modules\UserManagement\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\UserManagement\Entities\PerMenu;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $reporter = Role::create([
            'name' => 'Reporter',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $permissions = [
            'Dashboard' => [
                'read_dashboard',
            ],
            'Advertisement' => [
                'create_advertise',
                'read_advertise',
                'update_advertise',
                'delete_advertise',
                'Update Advertise' => [
                    'create_update_advertise',
                    'read_update_advertise',
                    'update_update_advertise',
                    'delete_update_advertise',
                ],
            ],
            'Analytics' => [
                'create_analytics',
                'read_analytics',
                'update_analytics',
                'delete_analytics',
                'Live Now' => [
                    'create_live_now',
                    'read_live_now',
                    'update_live_now',
                    'delete_live_now',
                ],
                'Location Based' => [
                    'create_location_Based',
                    'read_location_Based',
                    'update_location_Based',
                    'delete_location_Based',
                ],
                'News Based' => [
                    'create_news_based',
                    'read_news_based',
                    'update_news_based',
                    'delete_news_based',
                ],
                'Clear Analytics' => [
                    'create_clear_analytics',
                    'read_clear_analytics',
                    'update_clear_analytics',
                    'delete_clear_analytics',
                ],
            ],
            'Archive' => [
                'create_archive_setting',
                'read_archive_setting',
                'update_archive_setting',
                'delete_archive_setting',
            ],
            'Category' => [
                'create_category',
                'read_category',
                'update_category',
                'delete_category',
            ],
            'Comments' => [
                'create_comment',
                'read_comment',
                'update_comment',
                'delete_comment',
            ],
            'Media Library' => [
                'create_media_library',
                'read_media_library',
                'update_media_library',
                'delete_media_library',
                'Photo Upload' => [
                    'create_photo_upload',
                    'read_photo_upload',
                    'update_photo_upload',
                    'delete_photo_upload',
                ],
                'Photo List' => [
                    'create_photo_list',
                    'read_photo_list',
                    'update_photo_list',
                    'delete_photo_list',
                ],
            ],
            'Menu' => [
                'create_menu_setup',
                'read_menu_setup',
                'update_menu_setup',
                'delete_menu_setup',
            ],
            'News' => [
                'create_news',
                'read_news',
                'update_news',
                'delete_news',
                'Post' => [
                    'create_post',
                    'read_post',
                    'update_post',
                    'delete_post',
                ],
                'Breaking News' => [
                    'create_breaking_news',
                    'read_breaking_news',
                    'update_breaking_news',
                    'delete_breaking_news',
                ],
                'Positioning' => [
                    'create_positioning',
                    'read_positioning',
                    'update_positioning',
                    'delete_positioning',
                ],
                'Photo Post' => [
                    'create_photo_post',
                    'read_photo_post',
                    'update_photo_post',
                    'delete_photo_post',
                ],
            ],
            'Page' => [
                'create_page',
                'read_page',
                'update_page',
                'delete_page',
                'Page List' => [
                    'create_page_list',
                    'read_page_list',
                    'update_page_list',
                    'delete_page_list',
                ],
            ],
            'Reporter' => [
                'create_reporter',
                'read_reporter',
                'update_reporter',
                'delete_reporter',
                'Subscribers' => [
                    'create_subscribers',
                    'read_subscribers',
                    'update_subscribers',
                    'delete_subscribers',
                ],
                'Last 20 Access' => [
                    'create_last_20_access',
                    'read_last_20_access',
                    'update_last_20_access',
                    'delete_last_20_access',
                ],
            ],
            'SEO' => [
                'create_seo',
                'read_seo',
                'update_seo',
                'delete_seo',
                'Meta setting' => [
                    'create_meta_setting',
                    'read_meta_setting',
                    'update_meta_setting',
                    'delete_meta_setting',
                ],
                'Social Site' => [
                    'create_social_site',
                    'read_social_site',
                    'update_social_site',
                    'delete_social_site',
                ],
                'Social Link' => [
                    'create_social_link',
                    'read_social_link',
                    'update_social_link',
                    'delete_social_link',
                ],
                'Rss & sitemap link' => [
                    'create_rss_sitemap_link',
                    'read_rss_sitemap_link',
                    'update_rss_sitemap_link',
                    'delete_rss_sitemap_link',
                ],
            ],
            'Setting' => [
                'create_setting',
                'read_setting',
                'update_setting',
                'delete_setting',
                '404 Page Setting' => [
                    'create_404_page_setting',
                    'read_404_page_setting',
                    'update_404_page_setting',
                    'delete_404_page_setting',
                ],
                'Color Setting' => [
                    'create_color_setting',
                    'read_color_setting',
                    'update_color_setting',
                    'delete_color_setting',
                ],
                'Social auth setting' => [
                    'create_social_auth_setting',
                    'read_social_auth_setting',
                    'update_social_auth_setting',
                    'delete_social_auth_setting',
                ],
                'Cache System' => [
                    'create_cache_system',
                    'read_cache_system',
                    'update_cache_system',
                    'delete_cache_system',
                ],
                'Date Field Setup' => [
                    'create_date_field_setup',
                    'read_date_field_setup',
                    'update_date_field_setup',
                    'delete_date_field_setup',
                ],
                'Panel Face' => [
                    'create_panel_face',
                    'read_panel_face',
                    'update_panel_face',
                    'delete_panel_face',
                ],
            ],
            'Theme Setup' => [
                'create_theme_setup',
                'read_theme_setup',
                'update_theme_setup',
                'delete_theme_setup',
            ],
            'Software Setup' => [
                'create_software_setup',
                'read_software_setup',
                'update_software_setup',
                'delete_software_setup',
            ],
            'Application' => [
                'create_application',
                'read_application',
                'update_application',
                'delete_application',
            ],
            'App Setting' => [
                'create_apps_setting',
                'read_apps_setting',
                'update_apps_setting',
                'delete_apps_setting',
            ],
            'Mail Setup' => [
                'create_mail_setup',
                'read_mail_setup',
                'update_mail_setup',
                'delete_mail_setup',
            ],
            'Space Credential' => [
                'create_space_credential',
                'read_space_credential',
                'update_space_credential',
                'delete_space_credential',
            ],
            'SMS Setup' => [
                'create_sms_setup',
                'read_sms_setup',
                'update_sms_setup',
                'delete_sms_setup',
            ],
            'Password Setting' => [
                'create_password_setting',
                'read_password_setting',
                'update_password_setting',
                'delete_password_setting',
            ],
            'Language' => [
                'create_language',
                'read_language',
                'update_language',
                'delete_language',
                'Add Language' => [
                    'create_add_language',
                    'read_add_language',
                    'update_add_language',
                    'delete_add_language',
                ],
            ],
            'Language Strings' => [
                'create_language_strings',
                'read_language_strings',
                'update_language_strings',
                'delete_language_strings',
            ],
            'User Management' => [
                'create_user_management',
                'read_user_management',
                'update_user_management',
                'delete_user_management',
            ],
            'Role List' => [
                'create_role_list',
                'read_role_list',
                'update_role_list',
                'delete_role_list',
            ],
            'User List' => [
                'create_user_list',
                'read_user_list',
                'update_user_list',
                'delete_user_list',
            ],
            'Factory Reset' => [
                'create_factory_reset',
                'read_factory_reset',
                'update_factory_reset',
                'delete_factory_reset',
            ],
            'Backup And Reset' => [
                'create_backup_and_reset',
                'read_backup_and_reset',
                'update_backup_and_reset',
                'delete_backup_and_reset',
            ],
            'Access Log' => [
                'create_access_log',
                'read_access_log',
                'update_access_log',
                'delete_access_log',
            ],
            'Web Setup' => [
                'create_web_setup',
                'read_web_setup',
                'update_web_setup',
                'delete_web_setup',
                'Setup Top Breaking Post' => [
                    'create_setup_top_breaking_post',
                    'read_setup_top_breaking_post',
                    'update_setup_top_breaking_post',
                    'delete_setup_top_breaking_post',
                ],
                'Home Page' => [
                    'create_home_page',
                    'read_home_page',
                    'update_home_page',
                    'delete_home_page',
                ],
                'Contact Page Setup' => [
                    'create_contact_page_setup',
                    'read_contact_page_setup',
                    'update_contact_page_setup',
                    'delete_contact_page_setup',
                ],
            ],
        ];

        foreach ($permissions as $menu => $sub_permissions) {
            $menuModel = PerMenu::firstOrCreate([
                'menu_name' => $menu,
            ]);

            if (is_array($sub_permissions)) {
                foreach ($sub_permissions as $key => $permission) {
                    // Check if $permission is an array (indicating nested sub-permissions)
                    if (is_array($permission)) {
                        // If it's an array, treat it as a submenu with multiple permissions
                        $subPerMenu = PerMenu::firstOrCreate([
                            'parentmenu_id' => $menuModel->id,
                            'menu_name' => $key,
                        ]);

                        // Loop through the sub-permissions
                        foreach ($permission as $subPermission) {
                            Permission::firstOrCreate([
                                'name' => $subPermission,
                                'per_menu_id' => $subPerMenu->id,
                            ])->assignRole($superAdmin);
                        }
                    } else {
                        // If it's not an array, treat it as a single permission
                        Permission::firstOrCreate([
                            'name' => $permission,
                            'per_menu_id' => $menuModel->id,
                        ])->assignRole($superAdmin);
                    }
                }
            } else {
                // If $sub_permissions is not an array, treat it as a single permission
                Permission::firstOrCreate([
                    'name' => $sub_permissions,
                    'per_menu_id' => $menuModel->id,
                ])->assignRole($superAdmin);
            }
        }
    }
}
