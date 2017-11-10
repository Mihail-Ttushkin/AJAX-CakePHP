<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

class CommentsController extends AppController
{

    public function index()
    {
        $this->paginate = [
            'contain' => ['Articles']
        ];
        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
        $this->set('_serialize', ['comments']);
    }

    public function view($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => ['Articles']
        ]);

        $this->set('comment', $comment);
        $this->set('_serialize', ['comment']);
    }

    public function add()
    {
        $comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $articles = $this->Comments->Articles->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'articles'));
        $this->set('_serialize', ['comment']);
    }
    
    public function addajax()
    {
        if ($this->request->is('json')) {
            $rezult = false;
            $comments = [];
            $comment = $this->Comments->newEntity();
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $rezult = 'Комментарий успешно сохранен';
                $comments = $this->Comments->find()->where(['article_id' => $this->request->getData(['article_id'])]);
            }
            $this->set(compact('comments', 'rezult'));
        }
        else throw new NotFoundException('Страницы не существует, либо у Вас отсутствуют права доступа к данному разделу!');
    }

    public function edit($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $articles = $this->Comments->Articles->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'articles'));
        $this->set('_serialize', ['comment']);
    }

    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('The comment has been deleted.'));
        } else {
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
