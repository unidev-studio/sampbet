@extends('welcome')
@section('content')
<header>
            <section class="express">
                <div class="container tc">
                    @if($page == 0)
                    <h2>Документы</h2>
                    <p><a href="/docs/end-user">1. Пользовательское соглашение</a></p>
                    <p><a href="/docs/policy">2. Политика конфиденциальности</a></p>
                    <p><a href="/docs/risks">3. Уведомление о рисках</a></p>
                    <p><a href="/docs/rules">4. Правила размещения ставок</a></p>
                    <p><a href="/docs/withdraw">5. Условия вывода средств</a></p>
                    <p><a href="/docs/abolition">6. Политика отмены и возврата платежей</a></p>
                    @elseif($page == 1)
                    <h2>Пользовательское соглашение</h2>
                    <p style="text-align: justify;">
                        <b>Настоящий документ «Пользовательское соглашение» представляет собой предложение `SAMP-BET` (далее – «Правообладатель») заключить безвозмездный договор на информационное обслуживание на изложенных ниже условиях.</b><br>
                        <i>Внимательно ознакомьтесь с условиями настоящего Пользовательского соглашения до начала использования Сервиса.<br>Если вы не согласны с условиями настоящего Соглашения и указанных в нем Обязательных документов или не имеете права на заключение договора на их основе, вам следует <u>незамедлительно прекратить</u> любое использование Сервиса!</i><br>
                    </p>
                    <h4>1. Общие положения</h4>
                    <p style="text-align: justify;">
                        1.1. В настоящем документе и вытекающих или связанных с ним отношениях Сторон применяются следующие термины и определения:<br>

                        а) Сервис – совокупность функциональных возможностей программно-аппаратных средств Правообладателя, включая Сайт и Контент, к которым Пользователю предоставляется доступ в целях информационного обслуживания.<br>

                        б) Сайт – автоматизированная информационная система, доступная в сети Интернет по адресу (включая поддомены) https://samp-bet.ru и сертификацию доменной зоны для безопасность данных Пользователей.<br>

                        в) Пользователь – вы и/или иное лицо, в интересах которого вы заключили настоящее Соглашение с Правообладателем в соответствии с требованиями действующего законодательства и настоящего Соглашения.<br>

                        г) Контент – любые информационные материалы, включая текстовые, графические, аудиовизуальные и прочие материалы, к которым можно получить доступ с использованием Сервиса.<br>

                        1.2. Использование вами Сервиса любым способом и в любой форме в пределах его объявленных функциональных возможностей, включая:<br>

                        a) просмотр Контента в рамках Сервиса;<br>
                        б) оформление подписки на информационную рассылку;<br>
                        в) направление сообщения с использованием онлайн-форм на Сайте;<br>
                        г) обращение в службу поддержки Сервиса по реквизитам, размещенным на Сайте;<br>
                        д) иное использование Сервиса, которое создает договор на условиях настоящего Соглашения и указанных в нем обязательных для Сторон документов в соответствии с положениями ст.437 и 438 Гражданского кодекса Российской Федерации.<br>

                        1.3. Воспользовавшись любой из указанных выше возможностей по использованию Сервиса вы подтверждаете, что:<br>

                        а) Ознакомились с условиями настоящего Соглашения и указанных в нем Обязательных документов в полном объеме до начала использования Сервиса.<br>
                        б) Принимаете все условия настоящего Соглашения и указанных в нем Обязательных документов в полном объеме без каких-либо изъятий и ограничений с вашей стороны и обязуетесь их соблюдать или прекратить использование Сервиса.<br>
                    </p>
                    <h4>2. Общие условия пользования Сервисом</h4>
                    <p style="text-align: justify;">
                        2.1. Обязательным условием заключения настоящего Соглашения является полное и безоговорочное принятие и соблюдение Пользователем в установленных ниже случаях требований и положений, определенных следующими документами («Обязательные документы»):<br>

                        а) Политика конфиденциальности, размещенная и/или доступная в сети Интернет по адресу /docs/policy, которая содержит правила предоставления и использования конфиденциальной информации, включая персональные данные Пользователя.<br>

                        2.2. Правообладатель вправе устанавливать лимиты и вводить иные технические ограничения использования Сервиса, которые время от времени будут доводиться до сведения Пользователей в форме и способом по выбору Правообладателя.<br>
                    </p>
                    <h4>3. Ограничения</h4>
                    <p style="text-align: justify;">
                        Соглашаясь с условиями настоящего ПОльзовательского соглашения, вы понимаете и признаете, что:<br>

                        3.1. К отношениям Сторон по предоставлению Сервиса на безвозмездной основе не подлежат применению положения законодательства о защите прав потребителей.<br>

                        3.2. Сервис предоставляется для использования в информационно-развлекательных целях на условиях «как есть», в связи с чем Пользователям не представляются какие-либо гарантии, что Сервис будет соответствовать всем требованиям Пользователя; услуги будут предоставляться непрерывно, быстро, надежно и без ошибок; результаты, которые могут быть получены с использованием Сервиса, будут точными и надежными; качество какого-либо продукта, услуги, информации и Контента, полученных с использованием Сервиса, будет соответствовать ожиданиям Пользователя; все ошибки в Контенте и/или программном обеспечении Сервиса будут исправлены.<br>

                        3.3. Поскольку Сервис находится на стадии постоянного дополнения и обновления новых функциональных возможностей, форма и характер предоставляемых услуг могут время от времени меняться без предварительного уведомления Пользователя. Правообладатель вправе по собственному усмотрению прекратить (временно или окончательно) предоставление услуг (или каких-либо отдельных функций в рамках услуг) всем Пользователям вообще или вам, в частности, без вашего предварительного уведомления.<br>

                        3.4. Пользователь не имеет права самостоятельно или с привлечением третьих лиц:<br>

                        а) копировать (воспроизводить) в любой форме и способом входящие в состав Сервиса Правообладателя программы для ЭВМ и базы данных, включая любые их элементы и Контент, без получения предварительного письменного согласия их владельца;
                        вскрывать технологию, эмулировать, декомпилировать, дизассемблировать, дешифровать, и производить иные аналогичные действия с Сервисом;<br>
                        б) создавать программные продукты и/или сервисы с использованием Сервиса без получения предварительного разрешения Правообладателя.<br>

                        3.5. При обнаружении ошибок в работе Сервиса или в размещенном на нем Контенте сообщите об этом Правообладателю по адресу, указанному в реквизитах или отдельно на Сайте для службы поддержки.<br>

                        3.6. При любых обстоятельствах ответственность Правообладателя ограничена и возлагается на него исключительно при наличии в его действиях вины, Пользователь может расчитывать на компенсацию за ошибку сервиса.<br>
                    </p>
                    <h4>4. Уведомления</h4>
                    <p style="text-align: justify;">
                        4.1. Пользователь соглашается получать от Правообладателя на электронный адрес и/или абонентский номер телефона, указанный вами при работе с Сервисом, информационные электронные сообщения (далее — «нотификаторы»).<br>

                        4.2. Правообладатель вправе использовать нотификаторы для информирования Пользователя об изменениях и новых возможностях Сервиса, об изменении Соглашения или указанных в нем Обязательных документов, а также для рассылок информационного или рекламного характера.<br>
                    </p>
                    <h4>5. Прочие условия</h4>
                    <p style="text-align: justify;">
                        5.1. Настоящее Пользовательское соглашение, порядок его заключения и исполнения, а также вопросы, не урегулированные настоящим Соглашением, регулируются действующим законодательством Российской Федерации.<br>

                        5.2. Все споры по Соглашению или в связи с ним подлежат рассмотрению в суде по месту нахождения Правообладателя в соответствии с действующим процессуальным правом Российской Федерации.<br>

                        5.3. Настоящее Соглашение может быть изменено или прекращено Правообладателем в одностороннем порядке без предварительного уведомления Пользователя и без выплаты какой-либо компенсации в связи с этим.<br>

                        5.4. Действующая редакция настоящего Соглашения размещена на Сайте Правообладателя и доступна в сети Интернет по адресу /docs.<br>

                        5.6. Реквизиты Правообладателя: <br><br>
                    
                        Ф.И.О: N/A<br>
                    ОГРН (ИП): Физическое лицо<br>
                    Адрес: N/A<br>
                    ИНН: N/A<br>
                    E-Mail: support@samp-bet.ru
                    </p>
                    @elseif($page == 2)
                    <h2>Политика конфидициальности</h2>
                    <p style="text-align: justify;">
                        Настоящая Политика конфиденциальности персональной информации (далее — Политика) действует в отношении всей информации, которую физ.лицо N/A (ИНН: N/A, адрес регистрации: N/A) и/или его аффилированные лица, могут получить о пользователе во время использования им сайта https://samp-bet.ru.<br>
                        Использование сайта https://samp-bet.ru означает безоговорочное согласие пользователя с настоящей Политикой и указанными в ней условиями обработки его персональной информации; в случае несогласия с этими условиями пользователь должен воздержаться от использования данного ресурса.<br>
                    </p>
                    <h4>1. Персональная информация пользователей, которую получает и обрабатывает сайт https://samp-bet.ru</h4>
                    <p style="text-align: justify;">
                        1.1. В рамках настоящей Политики под «персональной информацией пользователя» понимаются:<br>
                        1.1.1. Персональная информация, которую пользователь предоставляет о себе самостоятельно при оставлении заявки, совершении операции, регистрации (создании учётной записи) или в ином процессе использования сайта.<br>
                        1.1.2 Данные, которые автоматически передаются сайтом https://samp-bet.ru в процессе его использования с помощью установленного на устройстве пользователя программного обеспечения, в том числе IP-адрес, информация из cookie, информация о браузере пользователя (или иной программе, с помощью которой осуществляется доступ к сайту), время доступа, адрес запрашиваемой страницы.<br>
                        1.1.3. Данные, которые предоставляются сайту, в целях осуществления процесса пополнения баланса в личном кабинете, предоставления иных ценностей для посетителей сайта, в соответствии с деятельностью настоящего ресурса:<br>
                        а) Идентификатор<br>
                        б) Сумма<br>
                        1.1.4. Данные, которые предоставляются сайту, в целях запоминания учетной записи «нового» участника системы:<br>
                        а) Почтовый адрес<br>
                        б) Пароль (в зашифрованной sha256 методом)<br>
                        в) Промокод/Реферал<br>
                        1.2. Настоящая Политика применима только к сайту https://samp-bet.ru и не контролирует и не несет ответственность за сайты третьих лиц, на которые пользователь может перейти по ссылкам, доступным на сайте https://telllarion.express. На таких сайтах у пользователя может собираться или запрашиваться иная персональная информация, а также могут совершаться иные действия.<br>
                        1.3. Сайт в общем случае не проверяет достоверность персональной информации, предоставляемой пользователями, и не осуществляет контроль за их дееспособностью. Однако сайт https://samp-bet.ru исходит из того, что пользователь предоставляет достоверную и достаточную персональную информацию по вопросам, предлагаемым в формах настоящего ресурса, и поддерживает эту информацию в актуальном состоянии.<br>
                    </p>
                    <h4>2. Цели сбора и обработки персональной информации пользователей</h4>
                    <p style="text-align: justify;">
                        2.1. Сайт собирает и хранит только те персональные данные, которые необходимы для оказания услуг, предоставления иных ценностей для посетителей сайта https://samp-bet.ru.<br>
                        2.2. Персональную информацию пользователя можно использовать в следующих целях:<br>
                        2.2.1 Предоставление пользователю персонализированных услуг и сервисов<br>
                        2.2.2 Связь с пользователем, в том числе направление уведомлений, запросов и информации, касающихся использования сайта, оказания услуг, а также обработка запросов и заявок от пользователя<br>
                        2.2.3 Улучшение качества сайта, удобства его использования, разработка новых услуг<br>
                        2.2.4 Проведение статистических и иных исследований на основе предоставленных данных<br>
                    </p>

                    <h4>3. Условия обработки персональной информации пользователя и её передачи третьим лицам</h4>
                    <p style="text-align: justify;">
                        3.1. Сайт https://samp-bet.ru хранит персональную информацию пользователей в соответствии с внутренними регламентами конкретных сервисов.<br>

                        3.2. В отношении персональной информации пользователя сохраняется ее конфиденциальность, кроме случаев добровольного предоставления пользователем информации о себе для общего доступа неограниченному кругу лиц.<br>

                        3.3. Сайт https://samp-bet.ru вправе передать персональную информацию пользователя третьим лицам в следующих случаях:<br>

                        3.3.1. Пользователь выразил свое согласие на такие действия, путем согласия выразившегося в предоставлении таких данных;<br>

                        3.3.2. Передача необходима в рамках использования пользователем определенного сайта https://samp-bet.ru, либо для предоставления оказания услуги пользователю;<br>

                        3.3.3. Передача предусмотрена российским или иным применимым законодательством в рамках установленной законодательством процедуры;<br>

                        3.3.4. В целях обеспечения возможности защиты прав и законных интересов сайта https://samp-bet.ru или третьих лиц в случаях, когда пользователь нарушает Пользовательское соглашение сайта https://samp-bet.ru.<br>

                        3.4. При обработке персональных данных пользователей сайт https://samp-bet.ru руководствуется Федеральным законом РФ «О персональных данных».<br>
                    </p>

                    <h4>4. Изменение пользователем персональной информации</h4>
                    <p style="text-align: justify;">
                        4.1. Пользователь может в любой момент изменить (обновить, дополнить) предоставленную им персональную информацию или её часть, а также параметры её конфиденциальности, перейдя в настройки аккаунта в личном кабинете;<br>
                        4.2. Пользователь может в любой момент, отозвать свое согласие на обработку персональных данных, сообщив об нежелании участвовать в сервисе «tellarion.express» в разделе Контакты, разъяснив причину и предоставив доказательства о владении своей персональной информацией;<br>
                    </p>
                    <h4>5. Меры, применяемые для защиты персональной информации пользователей</h4>
                    <p style="text-align: justify;">
                        Сайт принимает необходимые и достаточные организационные и технические меры для защиты персональной информации пользователя от неправомерного или случайного доступа, уничтожения, изменения, блокирования, копирования, распространения, а также от иных неправомерных действий с ней третьих лиц.
                    </p>
                    <h4>6. Изменение Политики конфиденциальности. Применимое законодательство</h4>
                    <p style="text-align: justify;">
                        6.1. Сайт имеет право вносить изменения в настоящую Политику конфиденциальности. При внесении изменений в актуальной редакции указывается дата последнего обновления. Новая редакция Политики вступает в силу с момента ее размещения, если иное не предусмотрено новой редакцией Политики.<br>
                        6.2. К настоящей Политике и отношениям между пользователем и Сайтом, возникающим в связи с применением Политики конфиденциальности, подлежит применению право Российской Федерации.<br>
                    </p>
                    @elseif($page == 3)
                    <h2>Уведомление о рисках</h2>
                    <p style="text-align: justify;">
                        Если Вы собираетесь воспользоваться нашими сервисом с целью заработка, делая ставки, Вы должны всегда помнить и осознавать, что игровые сессии имеют труднопредсказуемый характер, а ставки всегда сопряжены со значительной степенью риска! Делая ставки на игровые события, Вы можете не только значительно приумножить свой капитал, но и полностью потерять его! Предоставленная информация в виде аналитики со стороны сервиса является субъективной точкой зрения автора сервиса, результат сервисной сессии может не совпасть с реальным итоговым результатом игрового мероприятия и не гарантирует получение прибыли!<br><br>
                        Если Вы все-таки приняли решение поставить ставку, никогда не нужно ставить всю сумму имеющего "баланса" на одну сессию. По ходу того или иного игрового состязания (capture, game event) всегда может возникнуть ряд нюансов, которые способны изменить ход сессии: отмена события связанной с игровыми проблемами. От этого никто не застрахован и предсказать подобные варианты невозможно. Во избежании потери "баланса" после одной неудачной ставки, распределите его минимум на 10 равных частей.<br><br>
                        Для того, чтобы зарабатывать на игровых ставках, необходимо обладать многими качествами: начиная от профессиональных знаний в том или ином виде игровых событий, такие как: технические сложности в игровом процессе, математические расклады, шансы в процентном соотношении и даже расчет игрового сервера на котором принимается ставка. Учитываются и личностные характеристики: спокойствие, хладнокровие, уравновешенность. Достаточно редко можно встретить человека, в котором данный симбиоз сочетается органично. Именно поэтому всегда стоит логично и уместно применять свои личные способности.<br><br>
                        Помните, что солидный финансовый доход в мире игры с нашим сервисом не достигается молниеносно. Никогда не стоит рисковать больше 20% "баланса" на одну ставку, даже если поединок кажется вам "железно выигрышным". Исключите из своего лексикона понятие "это полюбому должно зайти". Никто никому ничего не должен, особенно в таких мероприятиях.
                        Профессиональный беттинг исключает возможность стать миллионером за один день. Это тяжелый труд, а всем любителям сорвать "джек-пот" лучше подойдут лотереи или игровые автоматы.<br><br>
                        Важно придерживаться рекомендаций и не допускать распространенных ошибок!
                    </p>
                    <p style="text-align: justify;"><b>GLHF! «Good Luck, Have Fun!»</b></h2>
                    @elseif($page == 4)
                    <h2>Правила размещения ставок</h2>
                    <h4>Общее информирование</h4>
                    <p style="text-align: justify;">
                        В тех случаях, когда специальное правило для какого-либо вида игрового события противоречит общему правилу, общее правило не применяется. Победитель/и игровой сессии будет определен по окончанию игрового мероприятия. Мы не признаем опротестованных или отмененных решений с целью размещения ставок.<br><br>

                        Все размещенные результаты должны быть окончательными по истечении 24 часов, позже никакие запросы учитываться не будут. В течение 24 часов, после того как результаты были размещены, сервис будет только обнулять/корректировать неверные результаты, полученные из-за ошибок, вызванных человеческим фактором внутри игровых событий, ошибок системы или ошибок, допущенных источником, имеющим отношение к результатам.<br><br>

                        Если игровое событие не проводится в объявленную сервисом «SAMP-BET» дату, все ставки по данному событию считаются недействительными.<br><br>
                        В данный момент «SAMP-BET» принимает ставки, только по одному режиму «capture», возможно в дальнейшем будут добавлены дополнительные режимы ставок, которые не включают в себя выбор сторон.<br><br>
                    </p>
                    <h4>Capture «Капт»</h4>
                    <p style="text-align: justify;">

                        Даты и время начала игровых событий на нашем веб-сайте приводятся исключительно в ознакомительных целях и могут быть изменены. Это означает, что ставки будут считаться действительными, даже если дата и (или) время предложенного в игровой сессии указаны неправильно.<br><br>

                        Если же сессия приостановлена или отложена и не возобновляется в течение 12 часов с фактического запланированного времени начала, ставки на такую сессию аннулируются, а суммы ставок будут возвращены пользователям.<br><br>

                        Все выигрыши выплачиваются на основании официальных результатов, объявляемых соответствующими уполномоченными лицами сессии сервиса.<br><br>

                        Если при размещении ставки вариант ничьей был недоступен, будет учитываться результат дополнительного времени, если оно было добавлено.<br><br>

                        Если количество ставок одной из предложенных сторон будет ровнятся нулю, то сессия автоматически становится недействительной и вся сумма ставок, возвращается пользователю.<br>

                        Если банда отменяет свое участие в игровом мероприятии до его начала, но сама сессия уже обозначена как «Активна», ставки на победу будут недействительны, а суммы ставок будут возвращены. Это относится ко всем игрокам или командам, принимающим участие в игровых мероприятиях.<br><br>

                        Пример:<br>

                        The Ballas Gang против The Vagos Gang – Evolve Role Play 01 – по результатам игрового события «capture» - победила банда The Ballas Gang. Победители получают свой выигрышь согласно ставкам на банду The Ballas Gang, согласно актуальному коээфициенту сессии.
                    </p>
                    @elseif($page == 5)
                    <h2>Условия вывода средств</h2>
                    <p style="text-align: justify;">

                        Вывод средств осуществляется по вашему запросу (<a href="/panel/withdraw">в личном кабинете</a>).<br>Запрос на вывод направляется в Interkassa.com (API) и обработка может составить от 1 до 5 рабочих дней.
                        <br><b>В дальнейшем сервис «SAMP-BET» постарается решить проблему с длительным ожиданием вывода средств и осуществлять выплаты за короткий промежуток времени!</b><br><br>

                        Правила вывода средств:<br>

                        1. Выбрать доступный метод вывода <br>

                        2. Сумма должна достигать более 100р. <br>
                        
                        3. Корректно указанные реквизиты <br>

                        4. Вывод может быть приостановлен, если со стороны Interkassa возникли проблемы/вопросы или же со стороны сервиса «SAMP-BET». <br>

                        5. Нет активных ставок/сессий за последние 20-минут последней истории в личном кабинете.
                    </p>
                    @elseif($page == 6)
                    <h2>Политика отмены и возврата платежей</h2>
                    <p style="text-align: justify;">

                        <b>Для выполнения отмены или же возврата платежа, должно пройти не более 24 часа!</b><br><br>

                        Платеж подлежит возврату и отмене в том случае, если:<br><br>

                        -  сохранён кассовый чек или же номер оплаты на платежной системе Interkassa.com;<br>
                        - электронная услуга была не получена должным образом (пример: зачисление баланса в личный кабинет, прошло с ошибкой и не должным образом);<br>
                        - электронная услуга была не воспользована никаким образом (пример: зачислили баланс в личный кабинет, но передумали участвовать в мероприятиях сервиса).<br><br>

                        <i>Для отмены или возврата нужно обратиться по доступным <a href="/contacts">контактным данным</a> и сообщить о отмене или же возврату платежа, ожидать ответа оператора.</i>
                    @endif
                </div>
            </section>
@endsection