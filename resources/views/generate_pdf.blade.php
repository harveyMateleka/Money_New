
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">  
<style type="text/css">
    .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: auto;  
  height: auto; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 0px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.3em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 10px;
  text-align: center;
}

#affichage {
  display: inline-block;
  vertical-align: top;
  font-size: medium;
  text-decoration: underline;
  font-weight: bold;
  padding: 25px;

}

#affichage .caisse {
  text-align: left;
  float: left;
}

#affichage .client {
  text-align: right;
  float: right;
}
#affichage .caisse, .client {
  display: inline-block;
}




</style>

  </head>
  <body>
  <img src="colombelogo.jpeg" style=" border: 1px ;
    border-radius: 4px;
    padding: 0px;
    width:100px;"  alt="Brand Logo">
    <header class="clearfix">
      <div id="company" class="clearfix">
        <div>AGENCE BAUDOUIN TRANSFERT</div>
        <div>N AGR: BCC 0055/MF/A<br /> RCCM:148-3288 ID.NAT:6-610-N58598M</div>
        <div>Av KATSHI N:1031-KINSHASA/GOMBE</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      <div id="project">
            @if($indice=='1')
            <div><span>PROVENANCE :</span>{{$agence}}</div>
            <div style="text-transform:uppercase;"><span>EXPEDITEUR :</span>{{$expiditeur}}</div>
            <div style="text-transform:uppercase;"><span>TEL :</span>{{$telexp}}</div>
            <div><span>DATE ENVOIE :</span>{{$date}}</div>
            @else
            <div><span>PROVENANCE :</span>{{$agence}}</div>
            <div style="text-transform:uppercase;"><span>EXPEDITEUR :</span>{{$expiditeur}}</div>
            <div><span>DATE DE SORTIE:</span>{{$date}}</div>
            @endif                
      </div>
    </header>
    <h1>{{$entete}}</h1>
    <main>
    @if($indice=='1')
    <table>
        <thead>
          <tr>
            <th class="service" width='150%'>BENEFICIAIRE</th>
            <th class="service">Ville</th>
            <th class="service">TELEPHONE</th>
            <th class="service">MONTANT PAYE </th>
            <th class="service" width='100%'>CODE</th> 
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service" style="text-transform:uppercase;" width='100%'>{{$beneficiere}}</td>
            <td class="service">{{$ville}}</td>
            <td class="service">{{$tel1}}</td>
            <td class="service">{{$montant}} {{$devise}}</td>
            <td class="service" width='100'>{{$trans}}</td>
            
          </tr>
          <tr>
            <td colspan="3">TOTAL TRANSFERT :</td>
            <td class="total">{{$montant}} {{$devise}}</td>
          </tr>
          <tr>
            <td colspan="3">POURCENTAGE : </td>
            <td class="total">{{$montantcom}} {{$devise}}</td>
          </tr>
        </tbody>
      </table>
      <h3><u>RAISON :</u>  {{$raison}} </h3>
    @else
    <table>
        <thead>
          <tr>
            <th class="service">DESTINATION</th>
            <th class="service">VILLE</th>
            <th class="service" width='100'>BENEFICIAIRE</th>
            <th class="service">MONTANT PAYE </th>
            <th class="service" width='100'>CODE</th> 
          </tr>
        </thead>
        <tbody>
          <tr>
          <td class="service">{{$agencedest}}</td>
            <td class="service">{{$villedes}}</td>
            <td class="service" width='100'>{{$beneficiere}}</td>
            <td class="unit">{{$montant}} {{$devise}}</td>
            <td class="service" width='100'>{{$trans}}</td>
            
          </tr>
          <tr>
            <td colspan="4">POURCENTAGE </td>
            <td class="total">{{$montantcom}} {{$devise}}</td>
          </tr>
        </tbody>
      </table>
    @endif       
      <div id="notices">
        <div><u>NOTICE:</u></div>
        <div class="notice">Les frais d'envoi dans toutes nos agences est de 2% pour le USD et CDF.Le délais de retrait est de 1 mois avec une carte valide.</div>
        <div class="notice" style="font-weight: bold;">Notre numéro service  Client : +243 82 99 22228 </div>
      </div></br></br></br></br>
      <div id="affichage">
      <div class="caisse">Signature de Caissiere</div><div class="client">Signature de Client</div>
    
      </div>
         </main>
    <footer>
    
    </footer>
  </body>
</html> 

