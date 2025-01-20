<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Activity Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $club_id
 * @property string $name
 * @property \Cake\I18n\Date $date
 * @property string $location
 * @property int $budget
 * @property string $activitydescription
 * @property \Cake\I18n\Time $time
 * @property int $participant
 * @property string|null $ref_no
 * @property int $faculty_id
 * @property int|null $approvalstatus
 * @property \Cake\I18n\DateTime|null $approvaldate
 * @property string|null $approvalby
 * @property int $status
 * @property int $program_id
 * @property int $semester_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Club $club
 * @property \App\Model\Entity\Faculty $faculty
 * @property \App\Model\Entity\Program $program
 * @property \App\Model\Entity\Semester $semester
 */
class Activity extends Entity
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
        'user_id' => true,
        'club_id' => true,
        'name' => true,
        'date' => true,
        'location' => true,
        'budget' => true,
        'activitydescription' => true,
        'time' => true,
        'participant' => true,
        'ref_no' => true,
        'faculty_id' => true,
        'approvalstatus' => true,
        'approvaldate' => true,
        'approvalby' => true,
        'status' => true,
        'program_id' => true,
        'semester_id' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'club' => true,
        'faculty' => true,
        'program' => true,
        'semester' => true,
    ];
}
