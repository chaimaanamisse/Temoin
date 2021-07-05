let req = new XMLHttpRequest();

// console.log(req);

// on s'accroche au changement d'état
req.onreadystatechange = function(){
    if(req.readyState == 4 && (req.status == 200 || req.status == 0)){console.log(req);}else if(req.readyState < 4){
        console.log(req.readyState);
    }
}

// ouvrir la transaction et présices à cet objet vers quel élement il va devoir pointer 
// "le serveur" et sous quelle format càd la méthode qu'on utilisera

// sur notre objet on ouvre la connexion

// open pour ouvrir la connexion
// req.onreadystatechange = handleStateChange; 
req.open("GET", "http://localhost/creer_api/reservations/lire.php", true);

// false donne l'instruction à notre objet de fonctionner en mode synchrone
// càd tant qu'il n'aura pas recu de reponse du serveur le traitement va etre interrompue le code javascript 
// ne continue pas à s'exécuter

req.send();

// if(req.status == 200){
//     console.log(req);
//     console.log("ça fonctionne");
// }else{
//     console.log("erreur");
// }

export default {
    name: "firstFormulaire",
    data() {
      return {
        nom: "",
        prenom: "",
        age: "",
        cin: "",
        profession: "",
        ref: sessionStorage.getItem("reference"),
      };
    },
    methods: {
      async handleSubmit() {
        const data = {
          nom: this.nom,
          prenom: this.prenom,
          age: this.age,
          cin: this.cin,
          profession: this.profession,
        };
  
        fetch("http://localhost/Backend%20RDV/API/users/insertUser", {
          method: "POST",
          header: "Content-type: application/json",
          body: JSON.stringify(data),
        })
          .then((reponseBis) => reponseBis.json())
          .then(function (dataBis) {
            // this.reference = dataBis.ref;
            console.log(dataBis.ref);
            sessionStorage.setItem("reference", dataBis.ref);
            console.log(sessionStorage.getItem("reference"));
            alert("Your Reference is: " + dataBis.ref);
          });
      },
    },
  };
  </script>

