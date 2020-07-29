const doSearchAutocompleteUA = () => {
    setTimeout( () => {
        
        document.querySelector("#autoComplete")
            .addEventListener("autoComplete", ({ detail }) => {
            console.log(detail);
            if(detail.matches > 0){
                const baseHTML = `<ul id="idPrevSearch"></ul>`;
                const autoComplete = document.querySelector('#autoComplete');;
                autoComplete.insertAdjacentHTML('afterend', baseHTML);

                detail.results.forEach( ({ value }) => {
                    const li = document.createElement('li');
                    li.innerHTML = `${ value.codigo } - ${ value.descripcion }`;
                    document.querySelector('#idPrevSearch').insertAdjacentElement('afterbegin', li);
                    console.log(list)
                } );
            }
        });
        // The autoComplete.js Engine instance creator
        const autoCompletejs = new autoComplete({
            data: {
                src: async () => {
                    // Loading placeholder text
                    document
                        .querySelector("#autoComplete")
                        .setAttribute("placeholder", "Loading...");
                    //Query
                    const query = document.querySelector('#autoComplete').value;
                    // Fetch External Data Source
                    const source = await fetch(
                        `http://127.0.0.1:8000/ua/search/${query}`
                    );
                    const data = await source.json();
                    // Post loading placeholder text
                    document
                        .querySelector("#autoComplete")
                        .setAttribute("placeholder", "");
                    // Returns Fetched data
                    console.log(data);
                    return data;
                },
                key: ["descripcion"],
                cache: false
            },
            sort: (a, b) => {
                if (a.match < b.match) return -1;
                if (a.match > b.match) return 1;
                return 0;
            }
        });
     
    }, 1000);
};

