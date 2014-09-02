<?php
/**
 * Your comment
 *
 * @author staygreengored <sggr90q@gmail.com>
 * @since 1.0
 */

class AmoCrmOld {

    /**
     * Массив с параметрами, которые нужно передать методом POST к API системы
     * @var array
     */
    public $user = array(
        'USER_LOGIN'=>'raprogress@mail.ru', #Ваш логин (электронная почта)
        'USER_HASH'=>'de1b7264974c5ac53b045352e9c8d0ee' #Хэш для доступа к API (смотрите в профиле пользователя)
    );

    /**
     * Наш аккаунт - поддомен bdlp
     * @var string
     */
    public $subDomain = 'raprogress';
    /**
     * Информация о текущем аккаунте
     * @var array
     */
    public $account = array();

    /**
     * Информация о полях
     * @var array|bool
     */
    public $customFields = array();

    /**
     * Информация о контактах
     * @var int
     */
    public $contactId = 0;


    public $leadId;

    public $newLeadId;


    public function __construct ($userLogin = '', $userHash = '', $subDomain = '') {

        #Массив с параметрами, которые нужно передать методом POST к API системы
        if(!empty($userLogin) && !empty($userHash)) {
            $this->user=array(
                'USER_LOGIN'=>$userLogin, #Ваш логин (электронная почта)
                'USER_HASH'=>$userHash #Хэш для доступа к API (смотрите в профиле пользователя)
            );
        }
        if (!empty($subDomain))
            $this->subDomain = $subDomain;

        // Аунтефикация
        if(!$this->auth())
            exit('Ошибка аунтефикации! Проверьте данные.');

        // Здесь мы будем получать информацию об аккаунте
        $this->account = $this->currentAccount();
        $this->customFields = $this->fieldsInfo();
    }

    /**
     * Производит авторизацию пользователя в системе. Все методы API могут быть использованы только после авторизации.
     *
     * В ответ на запрос, при удачном входе, кроме тела ответа возвращается cookie файл, содержащий ключ сессии, аналогично работе с WEB-браузером.
     * При дальнейших запросах к API-методам нужно обратно передавать полученные cookie. Время жизни сессии - 15 минут.
     *
     * Все запросы к API происходят из под пользователя, чьи реквизиты были использованы при авторизации через данный метод.
     * При этом мы учитываем все права пользователя, т.е. через API нельзя получить больше данных, чем сам пользователь может просмотреть через
     * интерфейсы системы. Мы советуем для API создавать отдельного пользователя для более специфической настройки прав подключаемого приложения.
     *
     * @param bool $typeJson Если true то ответ возвращает в формате JSON, если false то в XML
     * @return bool
     */
    public function auth($typeJson = true) {
        #Формируем ссылку для запроса
        $link='https://'.$this->subDomain.'.amocrm.ru/private/api/auth.php';
        if ($typeJson)
            $link .= '?type=json';

        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL

        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query($this->user));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Заверашем сеанс cURL

        //Проверяем ответ CURL
        $this->CheckCurlResponse($code);

        /**
         * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
         * нам придётся перевести ответ в формат, понятный PHP
         */
        $Response=json_decode($out,true);
        $Response=$Response['response'];
        if(isset($Response['auth'])) #Флаг авторизации доступен в свойстве "auth"
            return true;
        return false;
    }

    /**
     * Здесь мы будем получать информацию об аккаунте
     * @return mixed
     */
    public function currentAccount() {
        $link='https://'.$this->subDomain.'.amocrm.ru/private/api/v2/json/accounts/current'; #$subdomain уже объявляли выше
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
        $this->checkCurlResponse($code);
        /**
         * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
         * нам придётся перевести ответ в формат, понятный PHP
         */
        $Response=json_decode($out,true);
        $account=$Response['response']['account'];
        return $account;
    }

    /**
     * Получим информацию о полях
     * @return bool
     */
    public function fieldsInfo(){
        $need=array_flip(array('POSITION','PHONE','EMAIL','IM'));
        if(isset($this->account['custom_fields'],$this->account['custom_fields']['contacts']))
            do
            {
                foreach($this->account['custom_fields']['contacts'] as $field)
                    if(is_array($field) && isset($field['id']))
                    {
                        if(isset($field['code']) && isset($need[$field['code']]))
                            $fields[$field['code']]=(int)$field['id'];
                        #SCOPE - нестандартное поле, поэтому обрабатываем его отдельно
                        #elseif(isset($field['name']) && $field['name']=='Сфера деятельности')
                        #	$fields['SCOPE']=$field;

                        $diff=array_diff_key($need,$fields);
                        if(empty($diff))
                            break 2;
                    }
                if(isset($diff))
                    die('В amoCRM отсутствуют следующие поля'.': '.join(', ',$diff));
                else
                    die('Невозможно получить дополнительные поля');
            }
            while(false);
        else
            die('Невозможно получить дополнительные поля');
        $custom_fields=isset($fields) ? $fields : false;
        return $custom_fields;
    }


    /**
     * Осуществляет поиск по таким полям как : почта, телефон и любым иным полям, Не осуществляет поиск по заметкам и задачам
     * @param $query
     */
    public function contactSearch($query) {
        $email = isset($email) ? $email : 'sd';
        $link='https://'.$this->subDomain.'.amocrm.ru/private/api/v2/json/contacts/list?query='.$query;
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
#Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);
        $this->checkCurlResponse($code);

        if($out)
        {
            $data = json_decode($out);
            $this->contactId = $data->response->contacts[0]->id;
            $this->newleadId = $data->response->contacts[0]->linked_leads_id;

        }
        else
            $this->contactId = 0;
    }

    /**
     * Здесь будет происходить добавление сделки
     * @param $name
     * @param int $responsible_user_id
     */
    public function leadAdd($name, $responsible_user_id = 23038834) {
        $leads['request']['leads']['add']=array(
            array(
                'name'=>$name,
                //'date_create'=>1298904164, //optional
                'status_id'=>7736268,
                'responsible_user_id'=>$responsible_user_id,
                'custom_fields' => array(
                ),
            )
        );
        #Формируем ссылку для запроса
        $link='https://'.$this->subDomain.'.amocrm.ru/private/api/v2/json/leads/set';
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($leads));
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $this->checkCurlResponse($code);

        /**
         * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
         * нам придётся перевести ответ в формат, понятный PHP
         */
        $Response=json_decode($out,true);

        if (isset($Response['response']['leads']['add']))
            $lead_id = $Response['response']['leads']['add'][0]['id'];
        else
            $lead_id = 0;
        $this->leadId = $lead_id;
    }

    public function contactSet($name, $email, $phone) {
        $this->contactSearch($phone);
        $contact=array(
            'name'=>$name,
            'linked_leads_id' => array_merge(array($this->leadId), array($this->newLeadId)),
            'custom_fields'=>array(
                array(
                    'id'=>$this->customFields['EMAIL'],
                    'values'=>array(
                        array(
                            'value'=>$email,
                            'enum'=>'WORK'
                        )
                    )
                )
            )
        );
        /*        if(!empty($company))
                    $contact+=array('company_name'=>$company);	*/
        if(!empty($phone))
            $contact['custom_fields'][]=array(
                'id'=>$this->customFields['PHONE'],
                'values'=>array(
                    array(
                        'value'=>$phone,
                        'enum'=>'OTHER'
                    )
                )
            );
        if ($this->contactId == 0)
            $set['request']['contacts']['add'][]=$contact;
        else {
            $contact['id'] = $this->contactId;
            $contact['last_modified'] = time();
            $set['request']['contacts']['update'][]=$contact;
        }

        #Формируем ссылку для запроса
        $link='https://'.$this->subDomain.'.amocrm.ru/private/api/v2/json/contacts/set';
        $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
        #Устанавливаем необходимые опции для сеанса cURL
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($set));
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

        $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        $this->checkCurlResponse($code);

        if($this->contactId == 0) {
            /**
             * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
             * нам придётся перевести ответ в формат, понятный PHP
             */
            $Response=json_decode($out,true);
            $Response=$Response['response']['contacts']['add'];

            $output='ID добавленных контактов:'.PHP_EOL;
            foreach($Response as $v)
                if(is_array($v))
                    $output.=$v['id'].PHP_EOL;
            return $output;
        }
    }

    /**
     * Проверка ответа CURL
     * @param $code
     */
    public function CheckCurlResponse($code)
    {
        $code=(int)$code;
        $errors=array(
            301=>'Moved permanently',
            400=>'Bad request',
            401=>'Unauthorized',
            403=>'Forbidden',
            404=>'Not found',
            500=>'Internal server error',
            502=>'Bad gateway',
            503=>'Service unavailable'
        );
        try
        {
            #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if($code!=200 && $code!=204)
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
        }
        catch(Exception $E)
        {
            die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        }
    }

    public function getData() {
        return array(
            'name'=>isset($_POST['name']) ? $_POST['name'] : 'ss',
            'company'=>isset($_POST['company']) ? $_POST['company'] : '',
            'position'=>isset($_POST['position']) ? $_POST['position'] : '',
            'phone'=>isset($_POST['phone']) ? $_POST['phone'] : '',
            'email'=>isset($_POST['email']) ? $_POST['email'] : 'sd',
            'web'=>isset($_POST['web']) ? $_POST['web'] : '',
            'jabber'=>isset($_POST['jabber']) ? $_POST['jabber'] : '',
            'scope'=>isset($_POST['scope']) && is_array($_POST['scope']) ? $_POST['scope'] : array()
        );
    }
}