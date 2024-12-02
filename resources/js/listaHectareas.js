console.log('LEGGOOO')
const hectareas = [
    {id: 1, nombre: 'Hectarea 1 ', location: 'Culiacan'},
    {id: 2, nombre: 'Hectarea 2 ', location: 'Mochis'},
    {id: 3, nombre: 'Hectarea 3 ', location: 'Sanalona'},
    {id: 4, nombre: 'Hectarea 4 ', location: 'Sinaloa Leyva'},
    {id: 5, nombre: 'Hectarea 5 ', location: 'Choix'},
    {id: 6, nombre: 'Hectarea 6 ', location: 'Navolato'},
    {id: 7, nombre: 'Hectarea 7 ', location: 'Culiacan'},
]

const listaHectareas = document.getElementById("sectionListaHectareas")

if (listaHectareas) {
    hectareas.forEach((hectarea) => {
        const div = document.createElement("button")
        div.textContent = `${hectarea.nombre} - ${hectarea.location}`
        div.className = "itemHectarea"
        listaHectareas.appendChild(div)
    });
}



