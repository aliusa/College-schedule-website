{% include 'Kaukaras.Admin/header.php' %}
{% include 'Kaukaras.Admin/sidebar.php' with {'page':'HELP'} %}

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
            Paskaitų tvarkaraščio informacinė sistema „Kaukaras“
            <small>Versija 2.5.6.3 (2016-09-02)</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-success">
                    <div class="box-body">
                        <p>Šios sistemos paskirtis atvaizduoti paskaitas aukštosios mokyklos bendruomenei, iš kurių
                            kiekviena gali būti redaguojama.</p>
                        <p>Sistema kaupia pakeitimų istoriją (kas, ką, kada, keitė, ištrynė, pridėjo), kokia buvo prieš
                            tai reikšmė ir po to. Pakeitimai prieinami per duomenų bazę.</p>
                        <p>Sistema kaupia administratorių prisijungimų istoriją, kuri leidžia peržiūrėti kas, kada, su
                            kokia naršykle, operacine sistema, iš kokio IP adreso buvo prisijungę arba mėginę
                            prisijungti prie egzistuojančių arba neegzistuojančių paskyrų.</p>
                        <h4>Su šia sistema jūs galite:</h4>
                        <p>Administruoti auditorijas, jų įrangą, dalykus, dėstytojus, grupes, jų pogrupius, vesti jų
                            tvarkaraščius.</p>
                        <p>Apie nustatytu laiku užimtas auditorijas arba grupes sistema apie tai praneša ir
                            galėsite pasirinkti ar išsaugoti nepaisint uždengimų, ar neišsaugoti ir keisti
                            laika.</p>
                        <h4>Su šia sistema jūs negalite</h4>
                        <p>Automatiškai generuoti tvarkaraščius.</p>
                        <p>Optimizuoti esamus tvarkaraščius.</p>
                        <p>Eksportuoti duomenų.</p>
                        <p>Importuoti duomenų.</p>
                        <p>Informuoti el.paštu.</p>
                    </div>
                </div>

                <div class="box box-primary">

                    <div class="box-header with-border">
                        <i class="fa fa-book"></i>

                        <h3 class="box-title">Instrukcija</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <p>Šiame puslapyje rasite instrukcijas kaip atliktie vienus ar kitus veiksmus.</p>

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading1">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapse1"
                                           aria-expanded="true" aria-controls="collapse1">
                                            1. Kaip sukurti grupę
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading1">
                                    <div class="panel-body">
                                        <p>Kairėje esantis mygtukas <b>Naujas</b> atidaro pasirinkties sąrašą, iš kurio
                                            pasirinkus <b>Grupė</b> yra atidaromas naujas langas.</p><br/>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_3.png"
                                             class="center-block"/><br/>
                                        <p>Atsidariusiame lange būtina pildyti viską išskyrus el.paštą.
                                            Išsiskleidžiamuose sąrašuose turite pasirinkti atitinkamus įrašus. Jei jų
                                            nėra - privalot juos sukurti ir iš naujo atidaryti naujos grupės kūrimo
                                            langą.</p>
                                        <p>Grupės pavadinimas privalo būti nuo 3 iki 20 simbolių.</p>
                                        <p>
                                            Jei grupė turi pogrupių, pvz. grupė padalinta į
                                            2 pogrupius, kuriem kai kurias paskaitas skaito atskiri dėstytojai. Tuomet
                                            reikia sukurti tuos pogrupius spaudžiant <b>Pridėti pogrupį</b> ir įvesti
                                            kiekvieno pogrupio pavadinimą.
                                        </p>
                                        <p>Kiekvienai grupei sistema automatiškai sukuria pogrupį pavadinimu <b>0</b>,
                                            kuriam priskiriama visa grupė.</p>
                                        <p>Spaudžiant <b>Išsaugoti</b> bus išsaugomas grupės įrašas. Apie sėkmingą
                                            išsaugojimą bus pranešta apatiniame dešiniajame kampe atsidariusiame
                                            pranešime. Jei grupė tokiu pavadinimu jau egzistuoja, tuomet išsaugant apie
                                            tai bus pranešta. Jei išsaugant iškilo klaida, tuomet rodys raudoną
                                            pranešimą arba blogiausiu atveju pranešimo išvis nerodys.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading2">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            2. Kaip sukurti dėstytoją
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading2">
                                    <div class="panel-body">
                                        <p>Kairėje esantis mygtukas <b>Naujas</b> atidaro pasirinkties sąrašą, iš kurio
                                            pasirinkus <b>Dėstytojas</b>
                                            yra atidaromas naujas langas.</p><br/>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_4.png"
                                             class="center-block"/><br/>
                                        <p>Atsidariusiame lange būtina įvesti <b>Vardą</b>, <b>pavardę</b>, <b>mokslinį
                                                laipsnį</b>.</p>
                                        <p>Laukelyje <b>Papildoma informacija</b> vedama informacija, kuri matoma tik
                                            administratoriams dėstytojo peržiūros lange.</p>
                                        <p>
                                            Išsiskleidžiančiame sąraše <b>Dirba semestrus</b> privalot nurodyti kuriuos
                                            semestrus dirba dėstytojas. Pagal pasirinktus semestrus atitinkamai <i>tvarkaraščio
                                                kūrimo lange bus rodomi tą semestrą dirbantys dėstytojai.</i>
                                        </p>
                                        <p>Spaudžiant <b>Išsaugoti</b> bus išsaugomas dėstyojo įrašas. Apie sėkmingą
                                            išsaugojimą bus pranešta apatiniame dešiniajame kampe atsidariusiame
                                            pranešime.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading3">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                            3. Kaip sukurti dalyką
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading3">
                                    <div class="panel-body">
                                        <p>Kairėje esantis mygtukas <b>Naujas</b> atidaro pasirinkties sąrašą, iš kurio
                                            pasirinkus <b>Dalykas</b>
                                            yra atidaromas naujas langas.</p><br/>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_118.png"
                                             class="center-block"/><br/>
                                        <p></p>
                                        <p>Spaudžiant <b>Išsaugoti</b> bus išsaugomas dalyko įrašas. Apie sėkmingą
                                            išsaugojimą bus
                                            pranešta apatiniame dešiniajame kampe atsidariusiame pranešime. Jei dalykas
                                            tokiu pavadinimu
                                            jei egzistuoja, tuomet spaudžiant <b>Išsaugoti</b> apatiniame dešiniajame
                                            kampe
                                            atsidarys
                                            raudonos spalvos pranešimas su informacija.</p>
                                        <p>Pasirinkus <b>Dalykas nebeskaitomas</b> dalykas administravimo dalykų sąraše
                                            bus
                                            perbrauktas,
                                            o naudotojų svetainės dėstytojų sąraše nebus rodomas.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading4">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            4. Kaip sukurti tvarkaraščio kortelę
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading4">
                                    <div class="panel-body">
                                        <p>Kairėje esantis mygtukas <b>Naujas</b> atidaro pasirinkties sąrašą, iš kurio
                                            pasirinkus <b>Tvarkaraštis</b>
                                            yra atidaromas naujas langas.<br/></p>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_119.png"
                                             class="center-block"/><br/>
                                        <h3>Pagrindinė informacija</h3>
                                        <p>Prieš kuriant tvarkaraštį, pirmiausia būtina sukurti <b>Modulį</b>, kurį
                                            pasirinksite
                                            išsiskleidžiančiame sąraše <b>Modulis</b>.</p>
                                        <p>Pasirinkus Modulį būtina pasirinkti bent vieną grupę, kuriai bus ši
                                            tvarkaraščio
                                            kortelė. Tai
                                            galima padaryti jau esant pasirinkus modulį, iš <b>Grupė (pogrupis)</b>
                                            sąraše
                                            pažymėjus
                                            reikiamą grupę arba pogrupį.</p>
                                        <p>Iš <b>Dėstytojai</b> išsiskleidžiančio sąrašo pasirinkite vieną dėstytoją,
                                            kuris
                                            skaitys
                                            paskaitą. Jei dėstytojai skirtingi grupėms (pogrupiams), tuomet reikės kurti
                                            atskiras
                                            tvarkaraščių korteles.</p>
                                        <p>Auditorija pasirenkama iš išsiskleidžiančio sąrašo.</p>
                                        <h3>Data ir laikas:</h3>
                                        <p>Paskaitų dažnumas nustatomas <b>Įvyksta kas</b>: Vieną kartą, kas savaitę,
                                            pasirinktomis dienomis.</p>
                                        <b>Toliau vykdykite vieną iš kitų instrukcijų priklausomai nuo to, kokio dažnumo
                                            reikia, pvz reikia kas 2 savaites, tuomet pasirinkite <b>Kas savaitę</b></b>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading4v1">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse4v1" aria-expanded="false" aria-controls="collapse4v1">
                                            4.1. Kaip sukurti tvarkaraščio kortelę su viena paskaita
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse4v1" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading4v1">
                                    <div class="panel-body">
                                        <p>Užpildę informaciją skirtuke <b>Pagrindinė informacija</b> galite pildyti
                                            šią.</p>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_121.png"
                                             class="center-block"/><br/>
                                        <p>Iš išsiskleidžiančio sąrašo <b>Įvyksta kas</b> pasirinkite <b>Vieną kartą</b>.
                                        </p>
                                        <p><b>Pradžios laikas</b> nustato kokiu laiku prasidės paskaita. Pildymo
                                            formatas: hh:mm, kur hh yra valandos, o mm minutės, pvz 09:40.</p>
                                        <p><b>Pabaigos laikas</b> nustato kokiu laiku pasibaigs paskaita. <b>Įprasta
                                                trukmė</b> nurodo, kad paskaita truks 1 val 30min. Pasirinkus <b>Kita
                                                trukmė</b> galite įvesti kitą paskaitos trukmę, pvz 00:45 - tai bus
                                            45minučių. <b>Baigiasi pasirinktu laiku</b> nurodo kuriuo laiku baigsis
                                            paskaita, pvz 15:30.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading4v2">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse4v2" aria-expanded="false" aria-controls="collapse4v2">
                                            4.2. Kaip sukurti tvarkaraščio kortelę pasikartojančią kas X savaitę (-es)
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse4v2" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading4v2">
                                    <div class="panel-body">
                                        <p>Užpildę informaciją skirtuke <b>Pagrindinė informacija</b> galite pildyti
                                            šią.</p>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_124.png"
                                             class="center-block"/><br/>
                                        <p>Iš išsiskleidžiančio sąrašo <b>Įvyksta kas</b> pasirinkite <b>Savaitę</b>.
                                        </p>
                                        <p><b>Kartojimas</b> nusako kas kiek savaičių ši tvarkaraščių kortelė kartosis.
                                            Jei kas savaitę, tuomet įveskite 1. Jei kas 2 savaites, tuomet įveskite 2 ir
                                            t.t.</p>
                                        <p><b>Šiomis dienomis</b> nusako kuriomis savaitės dienomis šis tvarkaraštis
                                            bus,
                                            pasirinkite dienas tiesiog spausdami ant dienos kvadratėlio. Pažymėtos
                                            dienos bus pažymėtos žaliai. Atžymėti dienas galima dar kartą spaudžiant ant
                                            tos dienos.</p>
                                        <p><b>Pradžios laikas</b> nustato kokiu laiku prasidės paskaita. Pildymo
                                            formatas: hh:mm, kur hh yra valandos, o mm minutės, pvz 09:40.</p>
                                        <p><b>Pabaigos laikas</b> nustato kokiu laiku pasibaigs paskaita. <b>Įprasta
                                                trukmė</b> nurodo, kad paskaita truks 1 val 30min. Pasirinkus <b>Kita
                                                trukmė</b> galite įvesti kitą paskaitos trukmę, pvz 00:45 - tai bus
                                            45minučių. <b>Baigiasi pasirinktu laiku</b> nurodo kuriuo laiku baigsis
                                            paskaita, pvz 15:30.</p>
                                        <p><b>Pradžios data</b> nusako nuo kurios kalendorinės dienos turi prasidėti tas
                                            tvarkaraštis. Ją pasirinkite paspausdami ant datos įvesties lauko ant
                                            piktogramos šalia ir pasirinktę atitinkamą datą. Atsidariusiame kalendoriuje
                                            galite naviguoti tarp mėnesių, metų. Šiandiena šiame kalendroriuke yra
                                            nuspalvinta geltonai</p>
                                        <p>Pasirinktyje <b>Pabaigos data</b> galima rinktis - ar šis tvarkaraštis
                                            baigsis nustatytą datą, ar po nustatytą kiekį paskaitų ar po nustatytą kiekį
                                            savaičių.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading4v3">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse4v3" aria-expanded="false" aria-controls="collapse4v2">
                                            4.3. Kaip sukurti tvarkaraščio kortelę, kurios paskaitos vyksta konkrečiomis
                                            dienomis
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse4v3" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading4v3">
                                    <div class="panel-body">
                                        <p>Užpildę informaciją skirtuke <b>Pagrindinė informacija</b> galite pildyti
                                            šią.</p>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_126.png"
                                             class="center-block"/><br/>
                                        <p>Iš išsiskleidžiančio sąrašo <b>Įvyksta kas</b> pasirinkite <b>Pasirinktomis
                                                dienomis</b>.
                                        </p>
                                        <p><b>Pradžios laikas</b> nustato kokiu laiku prasidės paskaita. Pildymo
                                            formatas: hh:mm, kur hh yra valandos, o mm minutės, pvz 09:40.</p>
                                        <p><b>Pabaigos laikas</b> nustato kokiu laiku pasibaigs paskaita. <b>Įprasta
                                                trukmė</b> nurodo, kad paskaita truks 1 val 30min. Pasirinkus <b>Kita
                                                trukmė</b> galite įvesti kitą paskaitos trukmę, pvz 00:45 - tai bus
                                            45minučių. <b>Baigiasi pasirinktu laiku</b> nurodo kuriuo laiku baigsis
                                            paskaita, pvz 15:30.</p>
                                        <p>Dienos, kada vyks paskaitos žymimos dešinėje esančiame kalendoriuje. Dienos
                                            pasirinkamos paspausdžiant ant datos. Kalendoriuje
                                            galite naviguoti tarp mėnesių, metų. Šiandiena šiame kalendoriuke yra
                                            nuspalvinta geltonai.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading4vx">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse4vx" aria-expanded="false" aria-controls="collapse4v2">
                                            4.x. Kodėl ilgai trunka kol parodo, kad tvarkaraščio kortelė išsaugota
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse4vx" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading4vx">
                                    <div class="panel-body">
                                        <p>Į duomenų bazę yra išsaugojama tvarkaraščio kortelė kiekvienai pasirinktai
                                            grupei ir kiekviena paskaita, bei audito įrašai, todėl išsaugojimas gali
                                            trukdi net iki 30 sekundžių, priklausomai nuo tiek kiek buvo įdėta paskaitų
                                            ir kiek grupių. Viskas priklauso nuo serverio spartos, užimtumo.</p>
                                        <p>Pvz jei paskaitų 16, tuomet tai gali trukti iki 30 sekundžių.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading5">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                            4. Kaip sukurti modulį
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse5" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading5">
                                    <div class="panel-body">
                                        <p>Kairėje esantis mygtukas <b>Naujas</b> atidaro pasirinkties sąrašą, iš kurio
                                            pasirinkus <b>Modulis</b> yra atidaromas naujas langas.<br/></p>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_127.png"
                                             class="center-block"/><br/>
                                        <p>Šioje forme reikia viską įvesti - Semestrą, dalyką, grupes (pogrupius),
                                            kreditų kiekį.</p>
                                        <p>Pasirinkus pogrupius iš pogrupių sąrašo jie atsiranda lentelėje, kurioje
                                            galite pažymėti, jei tas dalykas tam pogrupiui yra pasirenkamsis. Jei
                                            suklydot ir norit išimti pogrupį, tuomet pogrupių išsiskleidžiančio
                                            sąraše nuimkite varnelę nuo tos grupės ir pogrupis bus išimtas iš
                                            lentelės.</p>
                                        <p>Išsaugoti modulį spauskite mygtuką <b>Išsaugoti</b>.</p>
                                        <p>Sukūrus modulį, jį jau bus galima rinktis tvarkaraščio kortelėje.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading6">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                            5. Kaip pakeisti paskaitos auditoriją, laiką, datą, parašyti komentarą,
                                            ištrinti.
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse6" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading6">
                                    <div class="panel-body">
                                        <p>Iš kairėje esančio meniu pasirinkus <b>Moduliai</b> atidaro modulių sąrašą.
                                            Jame raskite reikiamą modulį ir spauskite ant eilutės, kuris atidarys
                                            modulioperžiūros puslapį.</p>
                                        <p>Paspaudus mygtuką <b>Peržiūrėti paskaitas</b> atidaroma lentelė su visomis
                                            paskaitomis. Norimos redaguoti paskaitos eilutėje spaudžiama
                                            <b>Redaguoti</b>, kuris atidarys paskaitos redagavimo langą.</p>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_139.png"
                                             class="center-block"/><br/>
                                        <p>Paskaitos redagavimo lange galima redaguoti Auditoriją, datą, pradžios laiką,
                                            pabaigos laiką, rašyti komentarą matomą visiems pagrindiniame naudotojų
                                            puslapyje prie paskaitos įrašo bei galima pažymėti, kad paskaita nevyks -
                                            tuomet naudotojų puslapyje prie paskaitos įrašo bus įrašytas komentaras
                                            "Paskaita nevyks" nuspalvintas raudona spalva.</p>
                                        <p>Paskaita ištrinama paskaitos peržiūros lange.</p>
                                        <img src="{{ baseUrl() }}/static/images/doc/Screenshot_140.png"
                                             class="center-block"/><br/>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading7">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                            7. Kaip sukurti įrangą?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse7" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading7">
                                    <div class="panel-body">
                                        <p>Kairėje esantis mygtukas <b>Naujas</b> atidaro pasirinkties sąrašą, iš kurio
                                            pasirinkus <b>Įranga</b> yra atidaromas naujas langas.</p><br/>
                                        <p>Vedant įrangą būtina pasirinkti įrangos tipą - <b>Techninė įranga</b> ar <b>Programinė
                                                įranga</b>.</p>
                                        <p>Prie Techninės įrangos priskiriama - dėstytojo kompiuteris, projektorius,
                                            kreidinė lenta, magnetinė lenta.</p>
                                        <p>Prie Programinės įrangos priskiriamos programos esančios kompiuteriuose -
                                            Stekas, Dia, MS Dynamics NAV, MS Office, MS Project, ArgoUML, XAMPP,
                                            Navicat, MySQL ir t.t.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading8">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse8" aria-expanded="false" aria-controls="collapse8">
                                            8. Kaip priskirti įrangą auditorijai?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse8" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading8">
                                    <div class="panel-body">
                                        <p>Kuriant naują auditoriją, pasirinkite skirtuką <b>Įranga</b> bus galima
                                            pažymėti varnele kompiuterinę ir techninę įrangą.</p>
                                        <p>Redaguojant auditoriją varnele pažymimos joje esanti programinė ir techninė
                                            įranga.</p>
                                        <p>Priskirta įranga išsaugoma spaudžiant <b>Išsaugoti</b>.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading9">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse9" aria-expanded="false" aria-controls="collapse9">
                                            9. Kaip ištrinti modulį?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse9" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading9">
                                    <div class="panel-body">
                                        <p>Iš modulių sąrašo pasirinkite modulį ir atsidarykite jo puslapį. Ištrinkite,
                                            jei yra, visas tvarkaraščių korteles. O jei nėra, tuomet spauskite mygtuką
                                            <b>Ištrinti</b>.</p>
                                        <p>Mygtukas <b>Ištrinti</b> rodomas tik tuomet, kai nėra tvarkaraščių kortelių
                                            modulyje.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading97">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse97" aria-expanded="false" aria-controls="collapse97">
                                            97. Ką daryti pastebėjus klaidą tvarkaraštyje
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse97" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading97">
                                    <div class="panel-body">
                                        <p>Apie pastebėjusias klaidas tvarkaraštyje praneškite el. paštu:</p>
                                        <ul>
                                            <li>Nuolatinių studijų skyriaus vedėjai {{ emailSchoolHelp1.Param1 }} {{
                                                emailSchoolHelp1.Param2 }}, <a
                                                    href="mailto:{{ emailSchoolHelp1.Title }}?Subject=Tvarkaraščio%20IS"
                                                    target="_top">{{ emailSchoolHelp1.Title }}</a></li>
                                            <li>Ištęstinių studijų skyriaus vedėjai {{ emailSchoolHelp2.Param1 }} {{
                                                emailSchoolHelp2.Param2 }}, <a
                                                    href="mailto:{{ emailSchoolHelp2.Title }}?Subject=Tvarkaraščio%20IS"
                                                    target="_top">{{ emailSchoolHelp2.Title }}</a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading98">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse98" aria-expanded="false" aria-controls="collapse98">
                                            98. Ką daryti pastebėjus klaidą sistemoje
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse98" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading98">
                                    <div class="panel-body">
                                        <p>Apie pastebėjusias klaidas praneškite el. paštu <a
                                                href="mailto:{{ adminEmail }}?Subject=Tvarkaraščio%20IS"
                                                target="_top">{{ adminEmail }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading99">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse"
                                           data-parent="#accordion"
                                           href="#collapse99" aria-expanded="false" aria-controls="collapse9">
                                            99. Turiu pasiūlymą, atsiliepimą
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse99" class="panel-collapse collapse" role="tabpanel"
                                     aria-labelledby="heading99">
                                    <div class="panel-body">
                                        <p>Visus atsiliepimus, pasiūlymus siųskite el. paštu <a
                                                href="mailto:{{ adminEmail }}?Subject=Tvarkaraščio%20IS"
                                                target="_top">{{ adminEmail }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="box box-info">

                    <div class="box-header with-border">
                        <i class="fa fa-calendar-check-o"></i>

                        <h3 class="box-title">Atnaujinimai</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="box-body">
                        <table class="table table-bordered table-responsive">
                            <thead>
                            <tr>
                                <th>Versija</th>
                                <th>Data</th>
                                <th>Informacija</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td nowrap>2.5.6.3</td>
                                <td nowrap>2016-09-02</td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5.6.2</td>
                                <td nowrap>2016-09-01</td>
                                <td>
                                    Administravimas:
                                    <ul>
                                        <li>Grupės puslapyje sutvarkyta, kad pirmą kartą rodo tvarkaraštį pagrindinėje
                                            informacijoje.
                                        </li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5.6.1</td>
                                <td nowrap>2016-08-21</td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5.6</td>
                                <td nowrap>2016-08-21</td>
                                <td>
                                    Administravimas:
                                    <ul>
                                        <li>Pridėta galimybė grupei sukurti pogrupius su savo nurodytu pavadinimu.
                                            Minimalus pogrupio pavadinimo ilgis 1 simbolis.
                                        </li>
                                        <li>Visų grupių pagrindinis pogrupio pavadinimas `0`, kuriam priskirta visa
                                            grupė.
                                        </li>
                                        <li>Pridėta galimybė moduliui pridėti pogrupius, keisti pogrupio
                                            `Pasirenkamasis` statusą, ištrinti pogrupį iš modulio, jei jis neturi
                                            tvarkaraščio kortelių.
                                        </li>
                                        <li>Pridėta galimybė dėstytojo puslapyje nurodyti kuriais semestrais dėstytojas
                                            dirba.
                                        </li>
                                        <li>Naujo tvarkaraščio kūrimo lange pasirinkus modulį, į dėstytojo pasirinktį
                                            įrašomi tik tie dėstytojai, kurie pažymėti kaip dirbantys tą semestrą.
                                        </li>
                                        <li>Pasisveikinimas `Labas rytas` nuo šiol bus rodomas tik pirmą kartą
                                            prisijungus tarp 7 ir 10 val. ryto.
                                        </li>
                                        <li>
                                            Pridėta "keep alive", kad prisijungimo sesija nesibaigtų kol yra atidarytas
                                            web puslapis.
                                        </li>
                                        <li>
                                            Dėstytojo kūrimo lange pridėta galimybė pasirinkti kuriais semestrais dirba
                                            kuriamas dėstytojas.
                                        </li>
                                        <li>Išimta galimybė redaguoti pagrindinio pogrupio pavadinimą.</li>
                                        <li>Grupei nuo šiol galima nurodyti įstojimo metus.</li>
                                    </ul>
                                    Duomenų bazė:
                                    <ul>
                                        <li>Pogrupių pavadinimo laukelis nebe skaičius, o tekstas.</li>
                                        <li>Professor_Semster pridėti trūkstami foreign key.</li>
                                        <li>Lentelė SubCluster perkelta į Cluster lentelę.</li>
                                        <li>Fakultetų sąrašas perkeltas į naują lentelę Faculty.</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5.5</td>
                                <td nowrap>2016-06-13</td>
                                <td>
                                    Administravimas:
                                    <ul>
                                        <li>Sutvarkyta modulių sąraše modulio kreditų skaičius ne tas rodomas</li>
                                        <li>Sutvarkyta modulių sąraše neveikia nuoroda į grupės puslapį</li>
                                        <li>Sutvarkyta grupės modulių sąraše išsiskleidžiančioje lentelėje rodomi visi
                                            tvarkaraščių šablonai. Dabar rodo tik tos grupės tvarkaraščių šablonus
                                        </li>
                                        <li>Sutvarkyta, kad neišsaugo tvarkaraščio kortelės paisirnkus pasikartojimą
                                            pasirinktomis dienomis
                                        </li>
                                    </ul>
                                    Naudotojų:
                                    <ul>
                                        <li>Visuose puslapiuose sutvarkyta, kad rodytų, jei paskaita vyksta rečiau nei
                                            kas savatę
                                        </li>
                                        <li>Išimta nuoroda į Moodle</li>
                                    </ul>
                                    Sistema:
                                    <ul>
                                        <li>Pridėta Moment.js biblioteka</li>
                                        <li>Bandoma paspartinti puslapio krovimo laiką</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5.4</td>
                                <td nowrap>2016-06-12</td>
                                <td>
                                    Administravimas:
                                    <ul>
                                        <li>Sutvarkytas, semestrų rikiavimo neišsaugojimas</li>
                                        <li>Sutvarkytas, tvarkaraščio kortelės neišsaugojimas kai pasirinkta pabaiga po
                                            x savaičių
                                        </li>
                                        <li>Perdarytas pagrindiame lange esantis paskaitų grafikas, vietoj stulpelinės
                                            diagramos (bar chart) dabar rodoma kalendorius su karčiu (heatmap).
                                        </li>
                                    </ul>
                                    Naudotojų:
                                    <ul>
                                        <li>Viršuje pridėta paveikslėlis su nuoroda į Moodle</li>
                                        <li>Pakeista nuoroda buvusi ant VKK teksto meniu juostoj, į pradinį puslapį</li>
                                        <li>Pridėta nuoroda į VKK, VKK logotipe viršuje.</li>
                                    </ul>
                                    Sistema:
                                    <ul>
                                        <li>Pridėta "christianklisch/slim-minify" biblioteka, kuri ištrina komentarus,
                                            tarpus, tuščias eilutes atvaizduodama puslapius, taip sumažindama perduodamų
                                            duomenų kiekį, kas lemia greitesnį puslapio atsaką.
                                        </li>
                                        <li>Kiekvieną dieną 4 val. ryto daroma automatinė duomenų bazės atsarginė
                                            kopija.
                                        </li>
                                    </ul>
                                    Duomenų bazė:
                                    <ul>
                                        <li>Išimta lentelė Module_Student.</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5.3</td>
                                <td nowrap>2016-06-10</td>
                                <td>
                                    Administravimas:
                                    <ul>
                                        <li>Sutvarkyta paskaitų grafiko lentelė</li>
                                        <li>Paskutinių prisijungimų lentelėje rodoma IP jei bandyta prisijungti į
                                            neegzistuojantį naudotoją
                                        </li>
                                    </ul>
                                    Naudotojų:
                                    <ul>
                                        <li>Pataisyta kalbos stilistika Pagalbos puslapyje</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5.2</td>
                                <td nowrap>2016-06-06</td>
                                <td>
                                    Administravimas:
                                    <ul>
                                        <li>Sukurtas Dokumentacijos puslapis, kuriame yra administravimo
                                            instrukcija ir atnaujinimų sąrašas.
                                        </li>
                                        <li>Tvarkaraščio kūrimo kortelėje pridėta pasirinktis, kad paskaitos baigis po X
                                            savaičių
                                        </li>
                                        <li>
                                            Sukurtas Informacijos skydelis
                                        </li>
                                    </ul>
                                    Naudotojų:
                                    <ul>
                                        <li>Sutvarkyta, kad nerodė paskaitos komentarų dienų sąraše prie paskaitos.</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5.1</td>
                                <td nowrap>2016-06-03</td>
                                <td>Naudotojų:
                                    <ul>
                                        <li>Sutaisyta neveikiantys klaviatūros strėlytėmis perėjimai į kitus
                                            puslapius.
                                        </li>
                                        <li>Sukurtas Pagalbos puslapis.</li>
                                    </ul>
                                    Administravimas:
                                    <ul>
                                        <li>Dalykų, dėstytojų grupių sąrašuose paspaudžiamos lentelės
                                            eilutės pakeistos nuorodomis į jų puslapius.
                                        </li>
                                    </ul>
                                    DB:
                                    <ul>
                                        <li>Lentelėje Lecture ir RecurringTask pridėti laukeliai DateCreated.</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.5</td>
                                <td nowrap>2016-06-01</td>
                                <td>DB:
                                    <ul>
                                        <li>Perdaryta Task lentelė į Module (Modulis), kurį prieš tai automatiškai kūrė,
                                            o dabar reikės pačiam kurti. Jis nuo šiol bendrina visus pogrupius ir pagal
                                            kreditų kiekį.
                                        </li>
                                        <li>ProfessorId perkeltas iš Lecture į RecurrintTask.</li>
                                        <li>SubClusterId perkeltas iš RecurrintTask į Module_Subcluster.</li>
                                        <li>Pridėta lentelė Student, Module_Student, Semester_Professor,
                                            Cluster_Student.
                                        </li>
                                    </ul>
                                    Administravimas:
                                    <ul>
                                        <li>Sukurta nuoroda Moduliai ir modulių kūrimo forma.</li>
                                        <li>Išimta dalyko tvarkaraštis</li>
                                        <li>Išimta dėstytojo tvarkaraštis</li>
                                    </ul>
                                    Naudotojų:
                                    <ul>
                                        <li>Sutvarkyta svetainė pagal naują DB struktūrą</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.3</td>
                                <td nowrap>2016-05-17</td>
                                <td>Administravimas:
                                    <ul>
                                        <li>Sukurtas įrangos sąrašas, jos kūrimas.</li>
                                        <li>Auditorijų kūrimo ir redagavimo modaluose pridėtas įrangos parinktis.</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.1</td>
                                <td nowrap>2016-06-03</td>
                                <td>Administravimas:
                                    <ul>
                                        <li>Įrašų kurimo langai perdaryti į modalus.</li>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>2.0</td>
                                <td nowrap>2015 Lapkritis</td>
                                <td>Atskirtos Naudotojų ir administravimo svetainės.
                                    Administravimo svetainė pasiekiama per /admin.
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>1.0</td>
                                <td nowrap>2015 Gegužė</td>
                                <td>Pirma versija.
                                    <ul>
                                        <li>Pagrindiniame puslapyje rodomos visos paskaitos.</li>
                                        <li>Grupių / dėstytojų
                                            puslapiuose
                                            rodomos visos jų paskaitos. Duomenų administravimas vyksta tam pačiam, kaip
                                            ir
                                            naudotojų
                                            puslapyje.
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
{% include 'Kaukaras.Admin/footer.php' %}