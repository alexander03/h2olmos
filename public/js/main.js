// Autocomplete UA
const doSearchUA = (input = '.js-ua-id', descr = '.js-ua-desc', resultNull = '#autoComplete_list1') => {

    var autoCompletejsUA = new autoComplete({
        data: {
            src: async () => {
                // Loading placeholder text
                document
                    .querySelector(input)
                    .setAttribute("placeholder", "Loading...");
       
                // Fetch External Data Source
                const headers = new Headers();
                headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                const config = {
                    headers,
                    method:'GET'
                };
                  //Query
                const query = document.querySelector(input).value;
                const source = await fetch(
                    `ua/search/${query}` , config
                );
                let data = await source.json();
                // Post loading placeholder text
                // Returns Fetched data
                return data;
            },
            key: [ "search" ],
            cache: false
        },
        sort: (a, b) => {
            if (a.match < b.match) return -1;
            if (a.match > b.match) return 1;
            return 0;
        },
        selector: input,
        threshold: 1,
        debounce: 0,
        searchEngine: "strict",
        highlight: true,
        maxResults: 5,
        resultsList: {
            render: true,
            container: source => {
                source.setAttribute("id", "autoComplete_list");
                source.setAttribute("class", "u-search-ua__result");
            },
            destination: document.querySelector(input),
            position: "afterend",
            element: "ul"
        },
        resultItem: {
            content: (data, source) => {
                source.innerHTML = data.match;
            },
            element: "li"
        },
        noResults: () => {
            document.querySelector(resultNull).innerText = 'Sin resultados';
        },
        onSelection: feedback => { //VA NUESTRA LOGICA
            document.querySelector(resultNull).innerText = '';
            const selection = feedback.selection.value;
            document.querySelector(input).value = selection.codigo;
            document.querySelector(descr).innerText = selection.descripcion;
            // console.log(feedback);
        }
    });
    
    // Toggle event for search input
    // showing & hidding results list onfocus / blur
    ["focus", "blur"].forEach(function(eventType) {
      const resultsList = document.querySelector(resultNull);
    
      document.querySelector(input).addEventListener(eventType, function() {
        // Hide results list & show other elemennts
        if (eventType === "blur") {
          resultsList.style.display = "none";
        } else if (eventType === "focus") {
          // Show results list & hide other elemennts
          resultsList.style.display = "block";
        }
      });
    });
};

//Autocomplete Grifo
const doSearchGrifo = () => {

    var autoCompletejsGrifo = new autoComplete({
        data: {
            src: async () => {
                // Loading placeholder text
                document
                    .querySelector(".js-grifo-id")
                    .setAttribute("placeholder", "Loading...");
       
                // Fetch External Data Source
                const headers = new Headers();
                headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                const config = {
                    headers,
                    method:'GET'
                };
                  //Query
                const query = document.querySelector('.js-grifo-id').value;
                const source = await fetch(
                    `abastecimiento/search/grifo/${query}` , config
                );
                let data = await source.json();
                // Post loading placeholder text
                // Returns Fetched data
                return data;
            },
            key: ["descripcion"],
            cache: false
        },
        sort: (a, b) => {
            if (a.match < b.match) return -1;
            if (a.match > b.match) return 1;
            return 0;
        },
        selector: ".js-grifo-id",
        threshold: 1,
        debounce: 0,
        searchEngine: "strict",
        highlight: true,
        maxResults: 5,
        resultsList: {
            render: true,
            container: source => {
                source.setAttribute("id", "autoComplete_list");
                source.setAttribute("class", "u-search-ua__result");
            },
            destination: document.querySelector(".js-grifo-id"),
            position: "afterend",
            element: "ul"
        },
        resultItem: {
            content: (data, source) => {
                source.innerHTML = data.match;
            },
            element: "li"
        },
        noResults: () => {
            document.querySelector("#autoComplete_list2").innerText = 'Sin resultados';
        },
        onSelection: feedback => { //VA NUESTRA LOGICA
            document.querySelector("#autoComplete_list2").innerText = '';
            const selection = feedback.selection.value;
            document.querySelector(".js-grifo-id").value = selection.descripcion;
            // console.log(feedback);
        }
    });
    
    // Toggle event for search input
    // showing & hidding results list onfocus / blur
    ["focus", "blur"].forEach(function(eventType) {
      const resultsList = document.querySelector("#autoComplete_list2");
    
      document.querySelector(".js-grifo-id").addEventListener(eventType, function() {
        // Hide results list & show other elemennts
        if (eventType === "blur") {
          resultsList.style.display = "none";
        } else if (eventType === "focus") {
          // Show results list & hide other elemennts
          resultsList.style.display = "block";
        }
      });
    });
};

//Autocomplete Conductor
const doSearchConductor = () => {

    var autoCompletejsConductor = new autoComplete({
        data: {
            src: async () => {
                // Loading placeholder text
                document
                    .querySelector(".js-conductor-id")
                    .setAttribute("placeholder", "Loading...");
       
                // Fetch External Data Source
                const headers = new Headers();
                headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                const config = {
                    headers,
                    method:'GET'
                };
                  //Query
                const query = document.querySelector('.js-conductor-id').value;
                const source = await fetch(
                    `abastecimiento/search/conductor/${query}` , config
                );
                let data = await source.json();
                // Post loading placeholder text
                // Returns Fetched data
                return data;
            },
            key: [ 'search' ],
            cache: false
        },
        sort: (a, b) => {
            if (a.match < b.match) return -1;
            if (a.match > b.match) return 1;
            return 0;
        },
        selector: ".js-conductor-id",
        threshold: 1,
        debounce: 0,
        searchEngine: "strict",
        highlight: true,
        maxResults: 5,
        resultsList: {
            render: true,
            container: source => {
                source.setAttribute("id", "autoComplete_list");
                source.setAttribute("class", "u-search-ua__result");
            },
            destination: document.querySelector(".js-conductor-id"),
            position: "afterend",
            element: "ul"
        },
        resultItem: {
            content: (data, source) => {
                source.innerHTML = data.match;
            },
            element: "li"
        },
        noResults: () => {
            document.querySelector("#autoComplete_list3").innerText = 'Sin resultados';
        },
        onSelection: feedback => { //VA NUESTRA LOGICA
            document.querySelector("#autoComplete_list3").innerText = '';
            const selection = feedback.selection.value;
            document.querySelector(".js-conductor-id").value = selection.dni;
            document.querySelector(".js-conductor-desc").innerText = `${ selection.nombres } ${ selection.apellidos }`; 
            // console.log(feedback);
        }
    });
    
    // Toggle event for search input
    // showing & hidding results list onfocus / blur
    ["focus", "blur"].forEach(function(eventType) {
      const resultsList = document.querySelector("#autoComplete_list3");
    
      document.querySelector(".js-conductor-id").addEventListener(eventType, function() {
        // Hide results list & show other elemennts
        if (eventType === "blur") {
          resultsList.style.display = "none";
        } else if (eventType === "focus") {
          // Show results list & hide other elemennts
          resultsList.style.display = "block";
        }
      });
    });
};

//Autocomplete Equipo
const doSearchEquipo = () => {

    var autoCompletejsEquipo = new autoComplete({
        data: {
            src: async () => {
                // Loading placeholder text
                document
                    .querySelector(".js-equipo-id")
                    .setAttribute("placeholder", "Loading...");
       
                // Fetch External Data Source
                const headers = new Headers();
                headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                const config = {
                    headers,
                    method:'GET'
                };
                  //Query
                const query = document.querySelector('.js-equipo-id').value;
                const source = await fetch(
                    `abastecimiento/search/equipo/${query}` , config
                );
                let data = await source.json();
                // Post loading placeholder text
                // Returns Fetched data
                return data;
            },
            key: [ 'search' ],
            cache: false
        },
        sort: (a, b) => {
            if (a.match < b.match) return -1;
            if (a.match > b.match) return 1;
            return 0;
        },
        selector: ".js-equipo-id",
        threshold: 1,
        debounce: 0,
        searchEngine: "strict",
        highlight: true,
        maxResults: 5,
        resultsList: {
            render: true,
            container: source => {
                source.setAttribute("id", "autoComplete_list");
                source.setAttribute("class", "u-search-ua__result");
            },
            destination: document.querySelector(".js-equipo-id"),
            position: "afterend",
            element: "ul"
        },
        resultItem: {
            content: (data, source) => {
                source.innerHTML = data.match;
            },
            element: "li"
        },
        noResults: () => {
            document.querySelector("#autoComplete_list4").innerText = 'Sin resultados';
        },
        onSelection: feedback => { //VA NUESTRA LOGICA
            document.querySelector("#autoComplete_list4").innerText = '';
            const selection = feedback.selection.value;
            document.querySelector('.js-equipo-id').value = selection.codigo;
            document.querySelector('.js-equipo-hidden').value = selection.tipo;
            document.querySelector('.js-equipo-desc').innerText = selection.descripcion;

            document.querySelector('.js-ua-id').value = selection.ua;
            document.querySelector('.js-ua-desc').innerText = selection.ua_desc;
            // console.log(feedback);
        }
    });
    
    // Toggle event for search input
    // showing & hidding results list onfocus / blur
    ["focus", "blur"].forEach(function(eventType) {
      const resultsList = document.querySelector("#autoComplete_list4");
    
      document.querySelector(".js-equipo-id").addEventListener(eventType, function() {
        // Hide results list & show other elemennts
        if (eventType === "blur") {
          resultsList.style.display = "none";
        } else if (eventType === "focus") {
          // Show results list & hide other elemennts
          resultsList.style.display = "block";
        }
      });
    });
};

//Fetch UA import Excel
const doImportExcel = () => {

    document.querySelector('.js-import-excel').addEventListener(
        'click', 
        (event) => document.querySelector('.js-import-excel-file').click()
    );

    document.querySelector('.js-import-excel-file').addEventListener(
        'change', 
        async (event) => {

            const file = event.target.files[0];
            if(file.type.includes('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') || 
                file.type.includes('application/vnd.ms-excel')){

                    const formData = new FormData();
                    formData.append('ua-excel', file);
        
                    const headers = new Headers();
                    headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                    const config = {
                        headers,
                        method:'POST',
                        body: formData
                    };
                   
                    const res = await fetch('ua/importar', config);
                    const { ok } = await res.json();
                    
                    //Carga tabla
                    if(ok) buscarCompaginado('', 'Accion realizada correctamente', 'Ua', 'OK');
                    else $('#modalError').modal('show');
    
            }
        }
    );
};

//Conversión de galones a litros
const convertGLtoL = () => {

    const refGL = document.querySelector('.js-qtd-gl');
    refGL.addEventListener('keyup', ({ target: { value } }) => {
        
        document.querySelector('.js-qtd-l').value = value * 3.7854;
    });
}


const doSearchRepuesto = () => {

    var autoCompletejsRepuesto = new autoComplete({
        data: {
            src: async () => {
                // Loading placeholder text
                document
                    .querySelector(".js-repuesto-id")
                    .setAttribute("placeholder", "Loading...");
       
                // Fetch External Data Source
                const headers = new Headers();
                headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                const config = {
                    headers,
                    method:'GET'
                };
                  //Query
                const query = document.querySelector('.js-repuesto-id').value;
                const source = await fetch(
                    `regrepveh/search/repuesto/${query}` , config
                );
                let data = await source.json();
                // Post loading placeholder text
                // Returns Fetched data
                return data;
            },
            key: [ 'search' ],
            cache: false
        },
        sort: (a, b) => {
            if (a.match < b.match) return -1;
            if (a.match > b.match) return 1;
            return 0;
        },
        selector: ".js-repuesto-id",
        threshold: 1,
        debounce: 0,
        searchEngine: "strict",
        highlight: true,
        maxResults: 5,
        resultsList: {
            render: true,
            container: source => {
                source.setAttribute("id", "autoComplete_list");
                source.setAttribute("class", "u-search-ua__result");
            },
            destination: document.querySelector(".js-repuesto-id"),
            position: "afterend",
            element: "ul"
        },
        resultItem: {
            content: (data, source) => {
                source.innerHTML = data.match;
            },
            element: "li"
        },
        noResults: () => {
            document.querySelector("#autoComplete_list3").innerText = 'Sin resultados';
        },
        onSelection: feedback => { //VA NUESTRA LOGICA
            document.querySelector("#autoComplete_list3").innerText = '';
            const selection = feedback.selection.value;
            document.querySelector(".js-repuesto-id").value = selection.codigo;
            document.querySelector(".js-repuesto-desc").innerText = selection.descripcion;
            document.querySelector(".js-repuesto-unidad").value = selection.unidad;
            document.querySelector(".js-repuesto-hiddenid").value = selection.id;
            document.querySelector(".js-repuesto-hiddendescripcion").value = selection.descripcion;
            // console.log(feedback);
        }
    });
    
    // Toggle event for search input
    // showing & hidding results list onfocus / blur
    /*["focus", "blur"].forEach(function(eventType) {
      const resultsList = document.querySelector("#autoComplete_list4");
    
      document.querySelector(".js-repuesto-id").addEventListener(eventType, function() {
        // Hide results list & show other elemennts
        if (eventType === "blur") {
          resultsList.style.display = "none";
        } else if (eventType === "focus") {
          // Show results list & hide other elemennts
          resultsList.style.display = "block";
        }
      });
    });*/
};
const doSearchTrabajo = () => {

    var autoCompletejsTrabajo = new autoComplete({
        data: {
            src: async () => {
                // Loading placeholder text
                document
                    .querySelector(".js-trabajo-id")
                    .setAttribute("placeholder", "Loading...");
       
                // Fetch External Data Source
                const headers = new Headers();
                headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                const config = {
                    headers,
                    method:'GET'
                };
                  //Query
                const query = document.querySelector('.js-trabajo-id').value;
                const source = await fetch(
                    `regmanveh/search/trabajo/${query}` , config
                );
                let data = await source.json();
                // Post loading placeholder text
                // Returns Fetched data
                return data;
            },
            key: [ 'search' ],
            cache: false
        },
        sort: (a, b) => {
            if (a.match < b.match) return -1;
            if (a.match > b.match) return 1;
            return 0;
        },
        selector: ".js-trabajo-id",
        threshold: 1,
        debounce: 0,
        searchEngine: "strict",
        highlight: true,
        maxResults: 5,
        resultsList: {
            render: true,
            container: source => {
                source.setAttribute("id", "autoComplete_list");
                source.setAttribute("class", "u-search-ua__result");
            },
            destination: document.querySelector(".js-trabajo-id"),
            position: "afterend",
            element: "ul"
        },
        resultItem: {
            content: (data, source) => {
                source.innerHTML = data.match;
            },
            element: "li"
        },
        noResults: () => {
            document.querySelector("#autoComplete_list3").innerText = 'Sin resultados';
        },
        onSelection: feedback => { //VA NUESTRA LOGICA
            document.querySelector("#autoComplete_list3").innerText = '';
            const selection = feedback.selection.value;
            
            document.querySelector(".js-trabajo-id").value = selection.descripcion;
            document.querySelector(".js-trabajo-desc").innerText = selection.descripcion;
            document.querySelector(".js-trabajo-hiddenid").value = selection.id;
            document.querySelector(".js-trabajo-hiddendescripcion").value = selection.descripcion;
            // console.log(feedback);
        }
    });
    
    // Toggle event for search input
    // showing & hidding results list onfocus / blur
    /*["focus", "blur"].forEach(function(eventType) {
      const resultsList = document.querySelector("#autoComplete_list4");
    
      document.querySelector(".js-trabajo-id").addEventListener(eventType, function() {
        // Hide results list & show other elemennts
        if (eventType === "blur") {
          resultsList.style.display = "none";
        } else if (eventType === "focus") {
          // Show results list & hide other elemennts
          resultsList.style.display = "block";
        }
      });
    });*/
};
