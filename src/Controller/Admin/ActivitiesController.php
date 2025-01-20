<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

use AuditStash\Meta\RequestMetadata;
use Cake\Event\EventManager;
use Cake\Routing\Router;

/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 */
class ActivitiesController extends AppController
{
	public function initialize(): void
	{
		parent::initialize();

		$this->loadComponent('Search.Search', [
			'actions' => ['index'],
		]);
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
	}

	/*public function viewClasses(): array
    {
        return [JsonView::class];
		return [JsonView::class, XmlView::class];
    }*/
	
	public function json()
    {
		$this->viewBuilder()->setLayout('json');
        $this->set('activities', $this->paginate());
        $this->viewBuilder()->setOption('serialize', 'activities');
    }
	
	public function csv()
	{
		$this->response = $this->response->withDownload('activities.csv');
		$activities = $this->Activities->find();
		$_serialize = 'activities';

		$this->viewBuilder()->setClassName('CsvView.Csv');
		$this->set(compact('activities', '_serialize'));
	}
	
	public function pdfList()
	{
		$this->viewBuilder()->enableAutoLayout(false); 
        $this->paginate = [
            'contain' => ['Users', 'Clubs', 'Faculties', 'Programs', 'Semesters'],
			'maxLimit' => 10,
        ];
		$activities = $this->paginate($this->Activities);
		$this->viewBuilder()->setClassName('CakePdf.Pdf');
		$this->viewBuilder()->setOption(
			'pdfConfig',
			[
				'orientation' => 'portrait',
				'download' => true, 
				'filename' => 'activities_List.pdf' 
			]
		);
		$this->set(compact('activities'));
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
		$this->set('title', 'Activities List');
		$this->paginate = [
			'maxLimit' => 10,
        ];
        $query = $this->Activities->find('search', search: $this->request->getQueryParams())
            ->contain(['Users', 'Clubs', 'Faculties', 'Programs', 'Semesters']);
			//->where(['title IS NOT' => null])
        $activities = $this->paginate($query);
		
		//count
		$this->set('total_activities', $this->Activities->find()->count());
		$this->set('total_activities_archived', $this->Activities->find()->where(['status' => 2])->count());
		$this->set('total_activities_active', $this->Activities->find()->where(['status' => 1])->count());
		$this->set('total_activities_disabled', $this->Activities->find()->where(['status' => 0])->count());
		
		//Count By Month
		$this->set('january', $this->Activities->find()->where(['MONTH(created)' => date('1'), 'YEAR(created)' => date('Y')])->count());
		$this->set('february', $this->Activities->find()->where(['MONTH(created)' => date('2'), 'YEAR(created)' => date('Y')])->count());
		$this->set('march', $this->Activities->find()->where(['MONTH(created)' => date('3'), 'YEAR(created)' => date('Y')])->count());
		$this->set('april', $this->Activities->find()->where(['MONTH(created)' => date('4'), 'YEAR(created)' => date('Y')])->count());
		$this->set('may', $this->Activities->find()->where(['MONTH(created)' => date('5'), 'YEAR(created)' => date('Y')])->count());
		$this->set('jun', $this->Activities->find()->where(['MONTH(created)' => date('6'), 'YEAR(created)' => date('Y')])->count());
		$this->set('july', $this->Activities->find()->where(['MONTH(created)' => date('7'), 'YEAR(created)' => date('Y')])->count());
		$this->set('august', $this->Activities->find()->where(['MONTH(created)' => date('8'), 'YEAR(created)' => date('Y')])->count());
		$this->set('september', $this->Activities->find()->where(['MONTH(created)' => date('9'), 'YEAR(created)' => date('Y')])->count());
		$this->set('october', $this->Activities->find()->where(['MONTH(created)' => date('10'), 'YEAR(created)' => date('Y')])->count());
		$this->set('november', $this->Activities->find()->where(['MONTH(created)' => date('11'), 'YEAR(created)' => date('Y')])->count());
		$this->set('december', $this->Activities->find()->where(['MONTH(created)' => date('12'), 'YEAR(created)' => date('Y')])->count());

		$query = $this->Activities->find();

        $expectedMonths = [];
        for ($i = 11; $i >= 0; $i--) {
            $expectedMonths[] = date('M-Y', strtotime("-$i months"));
        }

        $query->select([
            'count' => $query->func()->count('*'),
            'date' => $query->func()->date_format(['created' => 'identifier', "%b-%Y"]),
            'month' => 'MONTH(created)',
            'year' => 'YEAR(created)'
        ])
            ->where([
                'created >=' => date('Y-m-01', strtotime('-11 months')),
                'created <=' => date('Y-m-t')
            ])
            ->groupBy(['year', 'month'])
            ->orderBy(['year' => 'ASC', 'month' => 'ASC']);

        $results = $query->all()->toArray();

        $totalByMonth = [];
        foreach ($expectedMonths as $expectedMonth) {
            $found = false;
            $count = 0;

            foreach ($results as $result) {
                if ($expectedMonth === $result->date) {
                    $found = true;
                    $count = $result->count;
                    break;
                }
            }

            $totalByMonth[] = [
                'month' => $expectedMonth,
                'count' => $count
            ];
        }

        $this->set([
            'results' => $totalByMonth,
            '_serialize' => ['results']
        ]);

        //data as JSON arrays for report chart
        $totalByMonth = json_encode($totalByMonth);
        $dataArray = json_decode($totalByMonth, true);
        $monthArray = [];
        $countArray = [];
        foreach ($dataArray as $data) {
            $monthArray[] = $data['month'];
            $countArray[] = $data['count'];
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200])->all();
        $clubs = $this->Activities->Clubs->find('list', ['limit' => 200])->all();
        $faculties = $this->Activities->Faculties->find('list', ['limit' => 200])->all();
        $programs = $this->Activities->Programs->find('list', ['keyfield' => 'id', 'valueField' => function
        ($program) {
            return $program->code . ' : ' . $program->name;
        }, 'limit' => 200])->all();

        $semesters = $this->Activities->Semesters->find('list', ['limit' => 200])->all();
        $semesters = $this->Activities->Semesters->find('list', ['keyfield' => 'id', 'valueField' => function
        ($semester) {
            return $semester->code . ' : ' . $semester->session;
        }, 'limit' => 200])->all();
        $this->set(compact('activities', 'users', 'clubs', 'faculties', 'programs', 'semesters','monthArray', 'countArray'));
       
    }

    /**
     * View method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', 'Activities Details');
        $activity = $this->Activities->get($id, contain: ['Users', 'Clubs', 'Faculties', 'Programs', 'Semesters']);
        //this->set(compact('activity'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
		$users = $this->Activities->Users->find('list', limit: 200)->all();
		$clubs = $this->Activities->Clubs->find('list', limit: 200)->all();
		$faculties = $this->Activities->Faculties->find('list', limit: 200)->all();
		$programs = $this->Activities->Programs->find('list', limit: 200)->all();
		$semesters = $this->Activities->Semesters->find('list', limit: 200)->all();
        $this->set(compact('activity', 'users', 'clubs', 'faculties', 'programs', 'semesters'));

       
    }

    public function pdf($id = null)
    {
		$this->viewBuilder()->enableAutoLayout(false);
        $activity = $this->Activities->get($id, contain: ['Users', 'Clubs', 'Faculties', 'Programs', 'Semesters']);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'potrait',
                'download' => true,
                'filename' => 'Activity_' . $id . '.pdf'
            ]
            );
        $this->set('activity', $activity);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->set('title', 'New Activities');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Add']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Activities']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $activity = $this->Activities->newEmptyEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200])->all();
        $clubs = $this->Activities->Clubs->find('list', ['limit' => 200])->all();
        $faculties = $this->Activities->Faculties->find('list', ['limit' => 200])->all();
        $programs = $this->Activities->Programs->find('list', ['limit' => 200])->all();
        $semesters = $this->Activities->Semesters->find('list', ['limit' => 200])->all();
        $this->set(compact('activity', 'users', 'clubs', 'faculties', 'programs', 'semesters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', 'Activities Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Edit']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Activities']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $activity = $this->Activities->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The activity could not be saved. Please, try again.'));
        }
		$users = $this->Activities->Users->find('list', limit: 200)->all();
		$clubs = $this->Activities->Clubs->find('list', limit: 200)->all();
		$faculties = $this->Activities->Faculties->find('list', limit: 200)->all();
		$programs = $this->Activities->Programs->find('list', limit: 200)->all();
		$semesters = $this->Activities->Semesters->find('list', limit: 200)->all();
        $this->set(compact('activity', 'users', 'clubs', 'faculties', 'programs', 'semesters'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Delete']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Activities']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('The activity has been deleted.'));
        } else {
            $this->Flash->error(__('The activity could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function archived($id = null)
    {
		$this->set('title', 'Activities Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Archived']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Activities']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $activity = $this->Activities->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->getData());
			$activity->status = 2; //archived
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('The activity has been archived.'));

				return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The activity could not be archived. Please, try again.'));
        }
        $this->set(compact('activity'));
    }
}
