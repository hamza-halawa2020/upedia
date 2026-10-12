<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PermissionSeeder::class,
            RolesSeeder::class,
            QuestionTypeSeeder::class,
            AcademyCategoryProductSeeder::class,
            TrackTypeSeeder::class,
            AcademyProductSeeder::class,
            ChartOfAccountSeeder::class,
            CrmCallStatusSeeder::class,
            CrmWorkFlowSeeder::class,
            CrmLeadActionSeeder::class,
            LeadsStatusSeeder::class,
            CrmReasonSeeder::class,
            SmBaseGroupSeeder::class,
            SmBaseSetupSeeder::class,
            SmHumanDepartmentSeeder::class,
            TabSeeder::class,
            DepartmentTabSeeder::class,
            EmTypeSeeder::class,
            CertificatePaymentConfigurationSeeder::class,
            FirebaseNotificationConfigSeeder::class,
            TimeSlotSeeder::class,
            SmLeaveTypeSeeder::class,
            HrJobTitleSeeder::class,
            HrSettingSeeder::class,
            RuleSeeder::class,
            HrRuleLevelSeeder::class,
            TreasurySeeder::class,
            LeadDistributionSettingSeeder::class,
            LeadWorkflowRuleSeeder::class,
            LeadsReminderSettingSeeder::class,
            NationalitySeeder::class,
            PackageSeeder::class,
            PricingPlanTypeSeeder::class,
            LevelSeeder::class,
            ReferralSettingSeeder::class,
            RequestPrioritySeeder::class,
            RequestTypeSeeder::class,
            ScoreCategorySeeder::class,
            ScoreSectionSeeder::class,
            ScoreQuestionSeeder::class,
            ScoreQuestionDemoSeeder::class,
            ItSolutionSeeder::class,
            HrRequestTypeTableSeeder::class,
        ]);
    }
}
