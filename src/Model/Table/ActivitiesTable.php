<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Activities Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ClubsTable&\Cake\ORM\Association\BelongsTo $Clubs
 * @property \App\Model\Table\FacultiesTable&\Cake\ORM\Association\BelongsTo $Faculties
 * @property \App\Model\Table\ProgramsTable&\Cake\ORM\Association\BelongsTo $Programs
 * @property \App\Model\Table\SemestersTable&\Cake\ORM\Association\BelongsTo $Semesters
 *
 * @method \App\Model\Entity\Activity newEmptyEntity()
 * @method \App\Model\Entity\Activity newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Activity> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Activity get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Activity findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Activity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Activity> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Activity|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Activity saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Activity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Activity>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Activity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Activity> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Activity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Activity>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Activity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Activity> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActivitiesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('activities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Clubs', [
            'foreignKey' => 'club_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Faculties', [
            'foreignKey' => 'faculty_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Programs', [
            'foreignKey' => 'program_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Semesters', [
            'foreignKey' => 'semester_id',
            'joinType' => 'INNER',
        ]);
		$this->addBehavior('AuditStash.AuditLog');

		$this->addBehavior('Search.Search');
		$this->searchManager()
			->value('id')
            ->value('approvalstatus')
            ->value('faculty_id')
            ->value('user_id')
            ->value('program_id')
            ->value('semester_id')
            
				->add('approvalstatus', 'Search.Like', [
					//'before' => true,
					//'after' => true,
					'fieldMode' => 'OR',
					'multiValue' => true,
					'multiValueSeparator' => '|',
					'comparison' => 'LIKE',
					'wildcardAny' => '*',
					'wildcardOne' => '?',
					'fields' => ['approvalstatus'],
				])
                ->add('activity_date_from', 'Search.Compare', [
                    'fields' => [$this->aliasField('date')],
                    'operator' => '>='
                ])
                ->add('activity_date_to', 'Search.Compare', [
                    'fields' => [$this->aliasField('date')],
                    'operator' => '<='
                ]);
    }

   


    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('club_id')
            ->notEmptyString('club_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('location')
            ->requirePresence('location', 'create')
            ->notEmptyString('location');

        $validator
            ->integer('budget')
            ->requirePresence('budget', 'create')
            ->notEmptyString('budget');

        $validator
            ->scalar('activitydescription')
            ->requirePresence('activitydescription', 'create')
            ->notEmptyString('activitydescription');

        $validator
            ->time('time')
            ->requirePresence('time', 'create')
            ->notEmptyTime('time');

        $validator
            ->integer('participant')
            ->requirePresence('participant', 'create')
            ->notEmptyString('participant');

        $validator
            ->scalar('ref_no')
            ->maxLength('ref_no', 255)
            ->allowEmptyString('ref_no');

        $validator
            ->integer('faculty_id')
            ->notEmptyString('faculty_id');

        $validator
            ->integer('approvalstatus')
            ->allowEmptyString('approvalstatus');

        $validator
            ->dateTime('approvaldate')
            ->allowEmptyDateTime('approvaldate');

        $validator
            ->scalar('approvalby')
            ->maxLength('approvalby', 255)
            ->allowEmptyString('approvalby');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->integer('program_id')
            ->notEmptyString('program_id');

        $validator
            ->integer('semester_id')
            ->notEmptyString('semester_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['club_id'], 'Clubs'), ['errorField' => 'club_id']);
        $rules->add($rules->existsIn(['faculty_id'], 'Faculties'), ['errorField' => 'faculty_id']);
        $rules->add($rules->existsIn(['program_id'], 'Programs'), ['errorField' => 'program_id']);
        $rules->add($rules->existsIn(['semester_id'], 'Semesters'), ['errorField' => 'semester_id']);

        return $rules;
    }
}
