<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActivitiesFixture
 */
class ActivitiesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'club_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'date' => '2025-01-20',
                'location' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'budget' => 1,
                'activitydescription' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'time' => '02:17:46',
                'participant' => 1,
                'ref_no' => 'Lorem ipsum dolor sit amet',
                'faculty_id' => 1,
                'approvalstatus' => 1,
                'approvaldate' => '2025-01-20 02:17:46',
                'approvalby' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'program_id' => 1,
                'semester_id' => 1,
                'created' => '2025-01-20 02:17:46',
                'modified' => '2025-01-20 02:17:46',
            ],
        ];
        parent::init();
    }
}
