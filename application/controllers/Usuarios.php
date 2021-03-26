<?php

defined('BASEPATH') OR exit('Ação não permitida');

class Usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //Definir se há sessão.
    }

    public function index() {

        $data = array(
            'titulo' => 'Usuários cadastrados',
            'styles' => array(
                'vendor/datatables/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'vendor/datatables/jquery.dataTables.min.js',
                'vendor/datatables/dataTables.bootstrap4.min.js',
                'vendor/datatables/app.js'
            ),
            'usuarios' => $this->ion_auth->users()->result(),
        );

        // echo 'pre';
        // print_r($data['usuarios']);
        // exit();

        $this->load->view('layout/header', $data);
        $this->load->view('usuarios/index');
        $this->load->view('layout/footer');
    }

    public function edit($usuario_id = NULL) {

        //*** Verificar se não foi passado ou passado mais ele não existe
        if (!$usuario_id || !$this->ion_auth->user($usuario_id)->row()) {

            exit('Usuário não encontrado');
        } else {
            /*
             * [firs_name] => Admin
              [last_name] => istrator
              [email] => admin@admin.com
              [username] => administrator
              [active] => 1
              [perfil_usuario] => 1
              [password] =>
              [confirm_password] =>
              [usuario_id] => 1
             */
            
            //*** Fazendo debug
            //  echo '<pre>';
            //  print_r($this->input->post());
            //  exit();

            ///*** Validando o campo first_name
            $this->form_validation->set_rules('firs_name', 'O campo nome', 'trim|required');

            //*** Verificando a validação do campo
            if ($this->form_validation->run()) {

                exit('Validado');
                
            } else {
                

                $data = array(
                    
                    //*** Caso exista cria o array data
                    //*** Título da página
                    'titulo' => 'Editar usuário',
                    
                     //*** Estou enviando os dados deste usuário
                    'usuario' => $this->ion_auth->user($usuario_id)->row(),
                    
                    //*** Trazer o perfil do usuário
                    'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row(),
                );

                //*** Carregando as Views
                $this->load->view('layout/header', $data);
                $this->load->view('usuarios/edit');
                $this->load->view('layout/footer');
            }
        }
    }

}
