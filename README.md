Upute:
Zadatak je odrađen u Windows OS-u. Korišten je xampp i postman.

1. Download zip sa GIT repozitorija i lokalno extractati
   
2. Potrebno je importati bazu. Unutar phpMyAdmin odabrati import i odabrati file leon_api.sql 
	Unutar filea se nalazi kompletna baza sa potrebnim tablicama i podatcima
	
3. C/P svog sadrzaja extractanog foldera u xampp/htdocs (.sql file nije potreban)
	Unutar foldera se nalaze 3 filea i nove putanje trebaju izgledati:
		xampp\htdocs\leon\index.php -> file sa kodom api-api-a
		xampp\htdocs\leon\config.php -> file za spajanje na bazu podataka i secret_code-om
		xampp\htdocs\leon\.htaccess -> potrebno kako bi radile putanje '/leon/voucher/get' i '/leon/auth'
						
4. Nakon sto je baza importana, te api loklano hostat mozemo započeti testom uz pomoć Postmana
		HTTP metodu postaviti na POST prema putanji http://localhost/leon/auth
		Unutar Postman-a, kliknite na tab "Body".
		Zatim, odaberite "raw" format
		Unutar okvira za unos, unesite JSON objekt s parametrom "secret":
			{
			  "secret": "top-secret-code"
			}
		Kliknite na gumb "Send" 
		Nakon ovih radnju dobivamo token koji dalje koristimo, potrebno ga je kopirati
		
5. Slijedi dohvaćanje vouchera. Medotu postaviti na GET i putanju http://localhost/leon/voucher/get
		Kliknite na tab "Headers" kako biste dodali zaglavlje
		U polje "Key" unesite Authorization.
		U polje "Value" unesite Bearer <token>, gdje umjesto <token> ćete stvarno staviti generirani token koji ste dobili prilikom autorizacije.
			npr. ako je vaš token dsaj2h423jfa-1323-324jdfs, unesite Bearer dsaj2h423jfa-1323-324jdfs
		Kliknite na tab "Params" kako biste dodali parametre
			Key: voucher_provider
			Value: foo (ili bar, ovisno o kojem vaučeru želite dohvatiti)
			Ponovite ovaj korak za drugi parametar:
			Key: voucher_amount
			Value: 10.0 (ili 20.0, ovisno o kojem iznosu vaučera želite dohvatiti)
		Kliknite na gumb "Send" 
		
		
