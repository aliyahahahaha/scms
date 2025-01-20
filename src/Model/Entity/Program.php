<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Program Entity
 *
 * @property int $id
 * @property int $faculty_id
 * @property string $code
 * @property string $name
 * @property int $status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Faculty $faculty
 * @property \App\Model\Entity\Activity $activity
 */
class Program extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'faculty_id' => true,
        'code' => true,
        'name' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'faculty' => true,
        'activity' => true,
    ];
}
