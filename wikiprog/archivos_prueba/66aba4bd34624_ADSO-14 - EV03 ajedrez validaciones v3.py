#Documentación de funciones
#https://stackoverflow.com/questions/9195455/how-to-document-a-method-with-parameters

#Buen resumen Python
#https://www.freecodecamp.org/espanol/news/operadores-basicos-en-python-con-ejemplos/

def distancia( x1, x2, y1, y2 ):
    """
    Función que calcula la distancia en el plano cartesiano.
    https://www.uaeh.edu.mx/docencia/P_Presentaciones/prepa3/2019/Coordenadas.pdf
    @param: real Coordenada 1 en eje x
    @param: real Coordenara 2 en eje x
    @param: real Coordenada 1 en eje y
    @param: real Coordenara 2 en eje y
    @return:real la distancia entre dos puntos del plano. 
    """
    salida = 0
    salida = ((x2-x1)**2+(y2-y1)**2)**0.5
    return round(salida, 2) #Redondeamos con dos decimales.

def pendiente( x1, x2, y1, y2 ):
    """
    Función que calcula la pendiente en el plano cartesiano.
    https://es.wikipedia.org/wiki/Pendiente_(matem%C3%A1tica)
    Para valores con x iguales, por ejecutarse una división por cero
    se retornara el codigo -1.00001
    @param: real Coordenada 1 en eje x
    @param: real Coordenara 2 en eje x
    @param: real Coordenada 1 en eje y
    @param: real Coordenara 2 en eje y
    @return:real la pendiente entre dos puntos del plano. 
    """
    
    #Se valida que no se divida por cero.
    if x2-x1 != 0:
        salida = round((y2-y1)/(x2-x1),2)
    else:
        salida = -1.00001 #Código de error planeado.
        
    return salida

def validar_dato(dato = "", valor = -100):
    """
    Funcion para validar datos.
    @param: string Texto que significa una ficha o coordenada numérica.
    @return: real Si retorna negativo es no valido.
    """
    salida = 0
    band = False #Pias, los valores booleanos inician con mayúscula.
        
    #print("valor:", valor)
    
    while band == False: #Bandera para validar dato correcto.
        #print("band: ", band)
        
        while dato.isnumeric() == False:
            #print("Dato numérico ", dato.isnumeric()) 
            dato = input("Digita el dato nuevamente. \n")
        
        if int(dato) >= 0 and int(dato) < 8 or int(dato) == valor:
            band = True #Puede seguir, dato validado.
        else: 
            dato = "" #Si el dato o es correcto, lo borramos.
    
    #print("band: ", band, " Dato: ", dato)
    salida = dato
    
    return salida

#--------------------------------------------------------------

def valoracion(ficha1, ficha1X, ficha1Y, ficha2, ficha2X, ficha2Y):

    """
    Valora las fichas dependiendo de su posición.
    @param: real Tipo ficha 1.
    @param: real Columna ficha 1.
    @param: real Fila ficha 1.
    @param: real Tipo ficha 2.
    @param: real Columna ficha 2.
    @param: real Fila ficha 2.
    @return: texto Significa quien amenaza.
    """    

    salida = ""    
    d = distancia(ficha1X, ficha2X, ficha1Y, ficha2Y)
    p = pendiente(ficha1X, ficha2X, ficha1Y, ficha2Y)
    print("Distancia: ", d, " Pendiente: ", p)

    #Solo peones. Importa solo la distancia de la diagonal a un cuadro.
    if ficha1 == ficha2 and ficha1 == 1 and d == 1.41:
        salida = "Ambos peones se amenazan. \n"
        
    #Peon vs alfil.
    if ficha1 == 1 and ficha2 == 2 or ficha1 == 2 and ficha2 == 1:
        
        if d == 1.41: #Condición del peón.
            salida += "El peon amenaza al alfil. \n"
        
        #Usamos abs para el valor absoluto y despreciar el signo 
        #de la pendiente del alfil, puede ser 1 o -1 de acuerdo al giro de la diagonal.
        if abs(p) == 1:
            salida += "Alfil amenaza al peon. \n"
            
    #Peon vs torre.
    if ficha1 == 1 and ficha2 == 3 or ficha1 == 3 and ficha2 == 1:
        
        if d == 1.41: #Condición del peón.
            salida += "El peon amenaza a la torre. \n"
        
        #La torre maneja pendiente cero o -1.00001, esto se podoría mejorar mucho.
        if p == 0 or p == -1.00001:
            salida += "Torre amenaza al peon. \n"
            
      

    return salida  

#*************************************************************
#****************** M E N U **********************************
#*************************************************************

def menu():
    """
    Despliega un menu para el usuario.
    """
    opcion = -1
    ficha1 = 0
    ficha1X = 0
    ficha1Y = 0
    ficha2 = 0
    ficha2X = 0
    ficha2Y = 0
    
    while opcion != 0:
        
        opcion = int(validar_dato(input("Digite 1 para ingresar, 0 para salir. \n"),-1))
        #print("Opcion ", opcion)
        
        if opcion == 1:
            print("Valores fichas: 1 Peones, 2 Alfiles, 3 Torres.")
            ficha1 = int(validar_dato(input("Digite la ficha 1.")))
            ficha1Y = int(validar_dato(input("Digite la fila.")))
            ficha1X = int(validar_dato(input("Digite la Columna.")))
            ficha2 = int(validar_dato(input("Digite la ficha 2.")))
            ficha2Y = int(validar_dato(input("Digite la fila.")))
            ficha2X = int(validar_dato(input("Digite la Columna.")))
            #print( ficha1, ficha1X, ficha1Y, ficha2, ficha2X, ficha2Y )
            print(valoracion( ficha1, ficha1X, ficha1Y, ficha2, ficha2X, ficha2Y ))

#--------- Probando las funciones -------------------

#Si las coordenadas son iguales, hay una diagonal.
#Estas coordenadas representan un cuadro de distancia.
#print(distancia(0,1,0,1)) 

#Estas coordenadas representan una diagonal con mucha distancia distancia.
#print(distancia(0,8,0,8)) 

#Estas coordenadas representan una columna con mucha distancia distancia.
#print(distancia(5,5,1,8)) 

#Estas coordenadas representan un cuadro de distancia en diagonal.
#print(pendiente(0,1,0,1))

#Estas coordenadas representan un cuadro de distancia en diagonal.
#print(pendiente(1,0,0,1))

#Estas coordenadas representan fichas en la misma columna.
#Las fichas están en la columna 5. En este caso la ecuación
#podría retonar división por cero, por fortuna el programador 
#anticipó esto y retorna un código especal.
#print(pendiente(5,5,0,3)) 

#Estas coordenadas representan fichas en la misma fila.
#En ese caso la pendiente es cero y no hay problema.
#print(pendiente(5,7,2,2)) 


#----------- programa ajedrez, validaciones, no juego ------------

menu()
print("Tenga un buen dia.")

