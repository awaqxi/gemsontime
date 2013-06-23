<?php
class Model_Auth extends Zend_Auth
{
    protected static $_instance;

    /** @var $user Model_Entity_User */
    protected $user;

    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function login($userName, $password)
    {
        $authAdapter = $this->getAuthAdapter();
        $authAdapter->setIdentity($userName)
                    ->setCredential($password);

        $result = $this->authenticate($authAdapter);

        if($result->isValid()){
            $identity = $authAdapter->getResultRowObject();
            $authStorage = $this->getStorage();
            $authStorage->write($identity);
        }

        return $result->isValid();
    }

    protected function getAuthAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('user')
            ->setIdentityColumn('name')
            ->setCredentialColumn('password')
            ->setCredentialTreatment('MD5(CONCAT(name,?))');

        return $authAdapter;
    }

    /**
     * @return Model_Entity_User
     */
    public function getUser()
    {
        if(is_null($this->user) && Zend_Auth::getInstance()->hasIdentity()){
            $id = $this->getIdentity()->id;
            $this->user = Model_Mapper_User::getById($id);
        }
        return $this->user;
    }
}