<?php

namespace Database\Seeders;

use App\Models\ChangeApproval;
use App\Models\ChangeDeployment;
use App\Models\ChangeDevelopment;
use App\Models\ChangeLog;
use App\Models\ChangeRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'create-change-request',
            'edit-change-request',
            'delete-change-request',
            'submit-change-request',
            'approve-change-request',
            'reject-change-request',
            'assign-developer',
            'update-development',
            'deploy-change',
            'manage-users',
            'view-all-changes',
            'view-dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        $maker = Role::firstOrCreate(['name' => 'maker']);
        $maker->syncPermissions([
            'create-change-request',
            'edit-change-request',
            'submit-change-request',
            'view-dashboard',
        ]);

        $approver = Role::firstOrCreate(['name' => 'approver']);
        $approver->syncPermissions([
            'approve-change-request',
            'reject-change-request',
            'view-all-changes',
            'view-dashboard',
        ]);

        $developer = Role::firstOrCreate(['name' => 'developer']);
        $developer->syncPermissions([
            'update-development',
            'view-all-changes',
            'view-dashboard',
        ]);

        // Create demo users
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole('admin');

        $makerUser = User::firstOrCreate(
            ['email' => 'maker@example.com'],
            [
                'name' => 'John Maker',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $makerUser->assignRole('maker');

        $approverUser = User::firstOrCreate(
            ['email' => 'approver@example.com'],
            [
                'name' => 'Jane Approver',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $approverUser->assignRole('approver');

        $developerUser = User::firstOrCreate(
            ['email' => 'developer@example.com'],
            [
                'name' => 'Bob Developer',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $developerUser->assignRole('developer');

        // Create sample change requests
        $statuses = ['draft', 'submitted', 'approved', 'in_progress', 'code_review', 'merged', 'deployed', 'done'];
        $types = ['feature', 'bugfix', 'hotfix', 'enhancement', 'refactor', 'security'];
        $priorities = ['low', 'medium', 'high', 'critical'];
        $risks = ['low', 'medium', 'high', 'critical'];
        $modules = ['Authentication', 'Payment', 'Dashboard', 'Reporting', 'User Management', 'API Gateway', 'Notifications', 'Settings'];

        $sampleCRs = [
            ['title' => 'Implement Two-Factor Authentication', 'description' => 'Add 2FA support using TOTP for enhanced security', 'reason' => 'Security compliance requirement', 'change_type' => 'feature', 'priority' => 'high', 'risk' => 'medium', 'status' => 'in_progress', 'affected_module' => 'Authentication'],
            ['title' => 'Fix Payment Gateway Timeout', 'description' => 'Resolve timeout issues when processing payments via Stripe', 'reason' => 'Customer complaints about failed payments', 'change_type' => 'bugfix', 'priority' => 'critical', 'risk' => 'high', 'status' => 'code_review', 'affected_module' => 'Payment'],
            ['title' => 'Dashboard Performance Optimization', 'description' => 'Optimize database queries and add caching for dashboard metrics', 'reason' => 'Dashboard loading time exceeds 5 seconds', 'change_type' => 'enhancement', 'priority' => 'medium', 'risk' => 'low', 'status' => 'approved', 'affected_module' => 'Dashboard'],
            ['title' => 'Add Export to PDF Feature', 'description' => 'Allow users to export reports as PDF documents', 'reason' => 'Business requirement for offline report sharing', 'change_type' => 'feature', 'priority' => 'medium', 'risk' => 'low', 'status' => 'submitted', 'affected_module' => 'Reporting'],
            ['title' => 'Security Patch for XSS Vulnerability', 'description' => 'Patch identified XSS vulnerability in user input fields', 'reason' => 'Security audit findings', 'change_type' => 'security', 'priority' => 'critical', 'risk' => 'medium', 'status' => 'deployed', 'affected_module' => 'User Management'],
            ['title' => 'Refactor API Rate Limiting', 'description' => 'Refactor rate limiting implementation to use Redis', 'reason' => 'Current implementation does not scale', 'change_type' => 'refactor', 'priority' => 'low', 'risk' => 'medium', 'status' => 'draft', 'affected_module' => 'API Gateway'],
            ['title' => 'Push Notification Integration', 'description' => 'Integrate Firebase Cloud Messaging for push notifications', 'reason' => 'Improve user engagement', 'change_type' => 'feature', 'priority' => 'high', 'risk' => 'medium', 'status' => 'done', 'affected_module' => 'Notifications'],
            ['title' => 'Hotfix: Login Session Expiry', 'description' => 'Fix premature session expiry causing unexpected logouts', 'reason' => 'Critical user experience issue', 'change_type' => 'hotfix', 'priority' => 'critical', 'risk' => 'high', 'status' => 'merged', 'affected_module' => 'Authentication'],
            ['title' => 'User Preference Settings Page', 'description' => 'Create a new settings page for user preferences and notifications', 'reason' => 'User feedback requesting customization options', 'change_type' => 'feature', 'priority' => 'low', 'risk' => 'low', 'status' => 'submitted', 'affected_module' => 'Settings'],
            ['title' => 'Database Migration to PostgreSQL', 'description' => 'Migrate from MySQL to PostgreSQL for better performance', 'reason' => 'Technical debt reduction and better JSON support', 'change_type' => 'refactor', 'priority' => 'high', 'risk' => 'critical', 'status' => 'draft', 'affected_module' => 'Dashboard'],
        ];

        foreach ($sampleCRs as $index => $crData) {
            $cr = ChangeRequest::create(array_merge($crData, [
                'code' => 'CR-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'impact' => 'Impact analysis for: ' . $crData['title'],
                'rollback_plan' => 'Revert to previous version and restore database backup if needed.',
                'testing_plan' => 'Unit tests, integration tests, and UAT sign-off required.',
                'target_release_date' => now()->addDays(rand(7, 30)),
                'created_by' => $makerUser->id,
            ]));

            // Add approval for approved+ statuses
            if (in_array($cr->status, ['approved', 'in_progress', 'code_review', 'merged', 'deployed', 'done'])) {
                ChangeApproval::create([
                    'change_request_id' => $cr->id,
                    'approver_id' => $approverUser->id,
                    'status' => 'approved',
                    'notes' => 'Approved. Proceed with implementation.',
                    'approved_at' => now()->subDays(rand(1, 5)),
                ]);
            }

            // Add development for in_progress+ statuses
            if (in_array($cr->status, ['in_progress', 'code_review', 'merged', 'deployed', 'done'])) {
                ChangeDevelopment::create([
                    'change_request_id' => $cr->id,
                    'git_branch' => $cr->getGitBranchName(),
                    'repository' => 'main-app',
                    'developer_id' => $developerUser->id,
                    'status' => in_array($cr->status, ['merged', 'deployed', 'done']) ? 'completed' : 'in_progress',
                ]);
            }

            // Add deployment for deployed/done statuses
            if (in_array($cr->status, ['deployed', 'done'])) {
                foreach (['dev', 'uat', 'staging', 'production'] as $env) {
                    ChangeDeployment::create([
                        'change_request_id' => $cr->id,
                        'environment' => $env,
                        'status' => 'deployed',
                        'deployed_by' => $adminUser->id,
                        'deployed_at' => now()->subDays(rand(0, 3)),
                    ]);
                }
            }

            // Add logs
            ChangeLog::create([
                'change_request_id' => $cr->id,
                'action' => 'created',
                'description' => 'Change request created.',
                'created_by' => $makerUser->id,
            ]);

            if ($cr->status !== 'draft') {
                ChangeLog::create([
                    'change_request_id' => $cr->id,
                    'action' => 'status_changed',
                    'description' => "Status changed to {$cr->status}.",
                    'created_by' => $makerUser->id,
                ]);
            }
        }
    }
}
