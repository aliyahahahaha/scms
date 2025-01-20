<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

use AuditStash\Meta\RequestMetadata;
use Cake\Event\EventManager;
use Cake\Routing\Router;

/**
 * Clubs Controller
 *
 * @property \App\Model\Table\ClubsTable $Clubs
 */
class ClubsController extends AppController
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
        $this->set('clubs', $this->paginate());
        $this->viewBuilder()->setOption('serialize', 'clubs');
    }
	
	public function csv()
	{
		$this->response = $this->response->withDownload('clubs.csv');
		$clubs = $this->Clubs->find();
		$_serialize = 'clubs';

		$this->viewBuilder()->setClassName('CsvView.Csv');
		$this->set(compact('clubs', '_serialize'));
	}
	
	public function pdfList()
	{
		$this->viewBuilder()->enableAutoLayout(false); 
		$clubs = $this->paginate($this->Clubs);
		$this->viewBuilder()->setClassName('CakePdf.Pdf');
		$this->viewBuilder()->setOption(
			'pdfConfig',
			[
				'orientation' => 'portrait',
				'download' => true, 
				'filename' => 'clubs_List.pdf' 
			]
		);
		$this->set(compact('clubs'));
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
		$this->set('title', 'Clubs List');
		$this->paginate = [
			'maxLimit' => 10,
        ];
        $query = $this->Clubs->find('search', search: $this->request->getQueryParams());
        $clubs = $this->paginate($query);
		
		//count
		$this->set('total_clubs', $this->Clubs->find()->count());
		$this->set('total_clubs_archived', $this->Clubs->find()->where(['status' => 2])->count());
		$this->set('total_clubs_active', $this->Clubs->find()->where(['status' => 1])->count());
		$this->set('total_clubs_disabled', $this->Clubs->find()->where(['status' => 0])->count());
		
		//Count By Month
		$this->set('january', $this->Clubs->find()->where(['MONTH(created)' => date('1'), 'YEAR(created)' => date('Y')])->count());
		$this->set('february', $this->Clubs->find()->where(['MONTH(created)' => date('2'), 'YEAR(created)' => date('Y')])->count());
		$this->set('march', $this->Clubs->find()->where(['MONTH(created)' => date('3'), 'YEAR(created)' => date('Y')])->count());
		$this->set('april', $this->Clubs->find()->where(['MONTH(created)' => date('4'), 'YEAR(created)' => date('Y')])->count());
		$this->set('may', $this->Clubs->find()->where(['MONTH(created)' => date('5'), 'YEAR(created)' => date('Y')])->count());
		$this->set('jun', $this->Clubs->find()->where(['MONTH(created)' => date('6'), 'YEAR(created)' => date('Y')])->count());
		$this->set('july', $this->Clubs->find()->where(['MONTH(created)' => date('7'), 'YEAR(created)' => date('Y')])->count());
		$this->set('august', $this->Clubs->find()->where(['MONTH(created)' => date('8'), 'YEAR(created)' => date('Y')])->count());
		$this->set('september', $this->Clubs->find()->where(['MONTH(created)' => date('9'), 'YEAR(created)' => date('Y')])->count());
		$this->set('october', $this->Clubs->find()->where(['MONTH(created)' => date('10'), 'YEAR(created)' => date('Y')])->count());
		$this->set('november', $this->Clubs->find()->where(['MONTH(created)' => date('11'), 'YEAR(created)' => date('Y')])->count());
		$this->set('december', $this->Clubs->find()->where(['MONTH(created)' => date('12'), 'YEAR(created)' => date('Y')])->count());

		$query = $this->Clubs->find();

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

        $this->set(compact('clubs', 'monthArray', 'countArray'));
    }

    /**
     * View method
     *
     * @param string|null $id Club id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->set('title', 'Clubs Details');
        $club = $this->Clubs->get($id, contain: ['Activities']);
        $this->set(compact('club'));

        $this->set(compact('club'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->set('title', 'New Clubs');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Add']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Clubs']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $club = $this->Clubs->newEmptyEntity();
        if ($this->request->is('post')) {
            $club = $this->Clubs->patchEntity($club, $this->request->getData());
            if ($this->Clubs->save($club)) {
                $this->Flash->success(__('The club has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The club could not be saved. Please, try again.'));
        }
        $this->set(compact('club'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Club id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->set('title', 'Clubs Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Edit']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Clubs']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $club = $this->Clubs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $club = $this->Clubs->patchEntity($club, $this->request->getData());
            if ($this->Clubs->save($club)) {
                $this->Flash->success(__('The club has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The club could not be saved. Please, try again.'));
        }
        $this->set(compact('club'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Club id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Delete']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Clubs']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $this->request->allowMethod(['post', 'delete']);
        $club = $this->Clubs->get($id);
        if ($this->Clubs->delete($club)) {
            $this->Flash->success(__('The club has been deleted.'));
        } else {
            $this->Flash->error(__('The club could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function archived($id = null)
    {
		$this->set('title', 'Clubs Edit');
		EventManager::instance()->on('AuditStash.beforeLog', function ($event, array $logs) {
			foreach ($logs as $log) {
				$log->setMetaInfo($log->getMetaInfo() + ['a_name' => 'Archived']);
				$log->setMetaInfo($log->getMetaInfo() + ['c_name' => 'Clubs']);
				$log->setMetaInfo($log->getMetaInfo() + ['ip' => $this->request->clientIp()]);
				$log->setMetaInfo($log->getMetaInfo() + ['url' => Router::url(null, true)]);
				$log->setMetaInfo($log->getMetaInfo() + ['slug' => $this->Authentication->getIdentity('slug')->getIdentifier('slug')]);
			}
		});
        $club = $this->Clubs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $club = $this->Clubs->patchEntity($club, $this->request->getData());
			$club->status = 2; //archived
            if ($this->Clubs->save($club)) {
                $this->Flash->success(__('The club has been archived.'));

				return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The club could not be archived. Please, try again.'));
        }
        $this->set(compact('club'));
    }
}
