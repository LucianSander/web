<?php

namespace Pessoa\Controller;

use Pessoa\Form\PessoaForm;
use Pessoa\Model\Pessoa;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PessoaController extends AbstractActionController
{

        // Add this property:
        private $table;

        // Add this constructor:
        public function __construct($table)
        {
            $this->table = $table;
        }

       public function indexAction()
    {
        return new ViewModel([
            'pessoas' => $this->table->fetchAll(),
        ]);
    }
    //controller adicionar
    public function adicionarAction()
    {
        $form = new PessoaForm();
        $form->get('submit')->setValue('Adicionar');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $pessoa = new Pessoa();
        $form->setInputFilter($pessoa->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $pessoa->exchangeArray($form->getData());
        $this->table->savePessoa($pessoa);
        return $this->redirect()->toRoute('pessoa');
    }

    //controller editar
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('pessoa', ['action' => 'adicionar']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $pessoa = $this->table->getPessoa($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('pessoa', ['action' => 'index']);
        }

        $form = new PessoaForm();
        $form->bind($pessoa);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($pessoa->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->savePessoa($pessoa);

        // Redirect to album list
        return $this->redirect()->toRoute('pessoa', ['action' => 'index']);
    }

    //controller deletar
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('pessoa');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deletePessoa($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('pessoa');
        }

        return [
            'id'    => $id,
            'pessoa' => $this->table->getPessoa($id),
        ];
    }
}