<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FacultiesFixture
 */
class FacultiesFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'created' => '2025-01-19 23:52:19',
                'modified' => '2025-01-19 23:52:19',
            ],
        ];
        parent::init();
    }
}
