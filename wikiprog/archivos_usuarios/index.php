<html lang="en"> 
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, imitial-scale=1.0">
    
</head>


<style>
* {
    box-sizing: border-box;
}

body {
   font-family: Arial, helvetica, sans-serif;
}

/* Style the header */
header {
    background-color: #666;
    padding: 3px;
    text-align: center;
    font-size: 35px;
    color: white;
}

/* Create two columns/boxes that floats next to each other */
nav {
  float: left;
  width: 30%;
  height: 300px; /* only for demostration, should be removed */
  background: #ccc;
  padding: 20px;
}

/* style the list inside the menu */
nav ul {
    list-style-type: none;
    padding: 0;
}

article {
    float: left;
    padding: 20px;
    width: 70%;
    background-color: #f1f1f1;
    height: 300px; /* only for demonstration, should be removed */
}

/* clear floats after the columns */
section::after {
    content: "";
    display: table;
    clear: both;
}

/* Style the footer */
footer {
    background-color: #777;
    padding: 10px;
    text-align: center;
    color: white;
}


@media (max-width: 600px) {
    nav, article {
        width: 100%;
        height: auto;
    }
}
</style>
</head>
<body> 

<header> 
  <h2>Losvideojuegos:pablo mondragon</h2>
</header>

<section> 
  <nav>
  <a href="inicio.php"> <img src="free.jpg" width="500"> </a>

</nav>

<article> 
    <h1>Freefire</h1>
    <a href="inicio.php"><p>Free Fire es un juego de acción y aventura de tipo battle royale que se juega en tercera persona.<br>
    El juego consiste en que hasta 50 jugadores caen desde un paracaídas en una isla en busca de armas<br> y 
    equipo para matar a los demás jugadores</p> </a>

 </article>
</section>


<section> 
  <nav> 
  <a href="pug.php"><img src="pubg.jpg" width="500"> </a>

  </nav>

  <article> 
  <h1>PUBG</h1>
    <a href="pug.php"><p>PUBG es un videojuego de acción en el cual hasta 100 jugadores pelean en una Batalla Real (Battle Royale)<br>
     un tipo de combate a muerte en el cual hay enfrentamientos para ser el último con vida. ...<br>
    También se pueden comprar otros objetos estéticos utilizando dinero real que el jugador podrá utilizar.</p></a>

 </article>
</section>

<section> 
  <nav>
  <a href="calldutty.php"><img src="call.jpg" width="500"></a>

</nav>

<article> 
    <h1>CALL OF DUTY MOBIL</h1>
    <a href="calldutty.php"><p>Call of Duty: Mobile es un juego tipo shooter  que incluye battel royal y multijugador </p></a>
 </article>
</section>

<section> 
  <nav>
  <a href="zelda.php"><img src="z.jpg" width="500"></a>

</nav>

<article> 
    <h1>zelda</h1>
    <a href="zelda.php"><p>un juego de aventura clasico en donde encarnamos a un heroe legedario</p></a>
 </article>
</section>

<section> 
  <nav>
  <a href="halo.php"><img src="h.jpg" width="200"></a>

</nav>

<article> 
    <h1>halo</h1>
    <a href="halo.php"><p>un juegos de disparos deon nuestro pricipal objetivo es salvar a la humanidad </p></a>
 </article>
</section>

<section> 
  <nav>
  <a href="fortnite.php"><img src="for.jpg" width="500"></a>

</nav>

<article> 
    <h1>FORNITE</h1>
    <a href="fortnite.php"><p>un juego batter royal donde tendremos que disparar y contruir para sobrebir </p></a>
 </article>
</section>



<section> 
  <nav>
  <a href="pou.php"><img src="po.jpg" width="450"></a>

</nav>

<article> 
    <h1>POU</h1>
    <a href="pou.php"><p>una mascota virtual a la que debemos cuidar y amar </p></a>
 </article>
</section>

</body> 




</html>


