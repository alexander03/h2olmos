// Autocomplete UA
const doSearchUA = () => {

    var autoCompletejsUA = new autoComplete({
        data: {
            src: async () => {
                // Loading placeholder text
                document
                    .querySelector(".js-ua-id")
                    .setAttribute("placeholder", "Loading...");
       
                // Fetch External Data Source
                const headers = new Headers();
                headers.append('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
                const config = {
                    headers,
                    method:'GET'
                };
                  //Query
                const query = document.querySelector('.js-ua-id').value;
                const source = await fetch(
                    `ua/search/${query}` , config
                );
                let data = await source.json();
                data = data.map( (elm) => {
                    let { codigo, ...arr } = elm;
                    codigo = codigo.toString();
    
                    return { codigo, ...arr };
                });
                // Post loading placeholder text
                // Returns Fetched data
                return data;
            },
            key: [ "codigo", "descripcion"],
            cache: false
        },
        sort: (a, b) => {
            if (a.match < b.match) return -1;
            if (a.match > b.match) return 1;
            return 0;
        },
        selector: ".js-ua-id",
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
            destination: document.querySelector(".js-ua-id"),
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
            document.querySelector("#autoComplete_list1").innerText = 'Sin resultados';
        },
        onSelection: feedback => { //VA NUESTRA LOGICA
            document.querySelector("#autoComplete_list1").innerText = '';
            const selection = feedback.selection.value;
            document.querySelector(".js-ua-id").value = selection.codigo;
            document.querySelector(".js-ua-desc").innerText = selection.descripcion;
            // console.log(feedback);
        }
    });
    
    // Toggle event for search input
    // showing & hidding results list onfocus / blur
    ["focus", "blur"].forEach(function(eventType) {
      const resultsList = document.querySelector("#autoComplete_list1");
    
      document.querySelector(".js-ua-id").addEventListener(eventType, function() {
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
            key: ["apellidos", "dni"],
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
            key: ["codigo", "descripcion"],
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
            document.querySelector(".js-equipo-id").value = selection.codigo;
            document.querySelector(".js-equipo-desc").innerText = selection.descripcion;
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
                        
                    const res = await fetch('/ua/importar', config);
                    const { ok } = await res.json();
                    
                    //Carga tabla
                    if(ok) buscarCompaginado('', 'Accion realizada correctamente', 'Ua', 'OK');
                    else $('#modalError').modal('show');
    
            }
        }
    );
};