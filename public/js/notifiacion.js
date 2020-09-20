const ActivarNotificaciones = ()=>{}

(function(){
	const headers = new Headers();
    headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    const config = {
       	headers,
       	method:'GET'
   	};
   	fetch('vehiculodocument/notifiacion', config)
		.then( res => res.json() )
		.then( data => {
			editButonNotify(data.numero);
		}) 
		.catch( error => console.log(error) );

	setInterval(function(config){
		fetch('vehiculodocument/notifiacion', config)
			.then( res => res.json() )
			.then( data => {
				editButonNotify(data.numero);
			}) 
			.catch( error => console.log(error) );
	},40000);
})();

const editButonNotify = (numero) =>{
	const button = document.getElmentByid('buttonNotify');
	const span = button.querySelector('span');
	if(numero = 0){
		span.classList.add('d-none');
	}else{
		span.classList.remove('d-none');
		span.innerText = numero;
	}
}