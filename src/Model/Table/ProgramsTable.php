<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Programs Model
 *
 * @property \App\Model\Table\FacultiesTable&\Cake\ORM\Association\BelongsTo $Faculties
 * @property \App\Model\Table\ActivitiesTable&\Cake\ORM\Association\HasOne $Activities
 *
 * @method \App\Model\Entity\Program newEmptyEntity()
 * @method \App\Model\Entity\Program newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Program> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Program get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Program findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Program patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Program> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Program|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Program saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Program>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Program>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Program>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Program> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Program>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Program>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Program>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Program> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProgramsTable extends Table
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

        $this->setTable('programs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Faculties', [
            'foreignKey' => 'faculty_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('Activities', [
            'foreignKey' => 'program_id',
        ]);
		$this->addBehavior('AuditStash.AuditLog');
		$this->addBehavior('Search.Search');
		$this->searchManager()
			->value('id')
				->add('search', 'Search.Like', [
					//'before' => true,
					//'after' => true,
					'fieldMode' => 'OR',
					'multiValue' => true,
					'multiValueSeparator' => '|',
					'comparison' => 'LIKE',
					'wildcardAny' => '*',
					'wildcardOne' => '?',
					'fields' => ['id'],
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
            ->integer('faculty_id')
            ->notEmptyString('faculty_id')
            ->add('faculty_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('code')
            ->maxLength('code', 10)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('status')
            ->notEmptyString('status');

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
        $rules->add($rules->isUnique(['faculty_id']), ['errorField' => 'faculty_id']);
        $rules->add($rules->existsIn(['faculty_id'], 'Faculties'), ['errorField' => 'faculty_id']);

        return $rules;
    }
}
