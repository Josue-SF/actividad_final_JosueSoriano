document.addEventListener('DOMContentLoaded', () => {
    const p = document.getElementById('peso');
    const a = document.getElementById('pluma');
    const b = document.getElementById('cal');
    const l = document.getElementById('out');

    function calcular(){
        const pes = parseFloat(p.value);
        const alt = parseFloat(a.value);

         if (isNaN(pes) || isNaN(alt) || alt === 0) {document.addEventListener('DOMContentLoaded', () => {
    const p = document.getElementById('peso');
    const a = document.getElementById('pluma');
    const b = document.getElementById('cal');
    const l = document.getElementById('out');
    const imcImagen = document.getElementById('imc-imagen');
    const body = document.body;

    function calcular() {
        const pes = parseFloat(p.value);
        const alt = parseFloat(a.value);

         if (isNaN(pes) || isNaN(alt) || alt <= 0 || pes <= 0) {
            l.innerHTML = "<span style='color: red;'>Ingrese valores válidos y positivos.</span>";
            body.className = 'bg-default';
            imcImagen.src = 'img/normal.png'; 
            return;
        }

        let imc = pes / (alt * alt);
        let imcRedondeado = imc.toFixed(2);
        
        let clasificacion = '';
        let imagenSrc = '';
        let fondoClase = '';

        if (imc < 18.50) {
            clasificacion = 'PESO BAJO';
            imagenSrc = 'img/infrapeso.png';
            fondoClase = 'bg-bajo';
        } else if (imc >= 18.50 && imc < 25) {
            clasificacion = 'PESO NORMAL';
            imagenSrc = 'img/normal.png';
            fondoClase = 'bg-normal';
        } else if (imc >= 25 && imc < 30) {
            clasificacion = 'SOBREPESO';
            imagenSrc = 'img/sobrepeso.png';
            fondoClase = 'bg-sobrepeso';
        } else if (imc >= 30 && imc < 35) {
            clasificacion = 'OBESIDAD LEVE';
            imagenSrc = 'img/obesidad.png';
            fondoClase = 'bg-leve';
        } else if (imc >= 35 && imc < 40) {
            clasificacion = 'OBESIDAD MEDIA';
            imagenSrc = 'img/obesidad.png';
            fondoClase = 'bg-media';
        } else {
            clasificacion = 'OBESIDAD MÓRBIDA';
            imagenSrc = 'img/obesidadM.png';
            fondoClase = 'bg-morbida';
            
            alert("¡ADVERTENCIA! Su IMC es de " + imcRedondeado + ". Es mayor o igual a 40, se recomienda buscar asistencia médica.");
        }

        l.innerHTML = `Tu IMC es: <b>${imcRedondeado}</b><br>Clasificación: <b>${clasificacion}</b>`;
        
        imcImagen.src = imagenSrc;
        
        body.className = ''; 
        body.classList.add(fondoClase); 
    }
    
    b.addEventListener('click', calcular);
    
    imcImagen.src = 'img/normal.png';
    body.classList.add('bg-default');
});
            l.textContent = "Ingrese valores válidos";
            return;
        }

        let R = (pes/(alt*alt));

        l.textContent = R.toFixed(3);

    }
    b.addEventListener('click', calcular);
    calcular();

});
