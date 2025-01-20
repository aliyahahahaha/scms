<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clubs Model
 *
 * @property \App\Model\Table\ActivitiesTable&\Cake\ORM\Association\HasOne $Activities
 *
 * @method \App\Model\Entity\Club newEmptyEntity()
 * @method \App\Model\Entity\Club newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Club> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Club get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Club findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Club patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Club> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Club|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Club saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Club>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Club>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Club>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Club> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Club>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Club>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Club>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Club> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClubsTable extends Table
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

        $this->setTable('clubs');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->hasOne('Activities', [
            'foreignKey' => 'club_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        return $validator;
    }
}
