import os

# Definir carpetas que serán OMITIDAS completamente
carpetas_omitidas = [".git", "__pycache__", "node_modules"]

# Definir carpetas cuyo contenido se OMITIRÁ (pero la carpeta en sí se mostrará)
contenido_omitido = ["vendor", "assets"]

def listar_directorio(ruta, nivel=0, max_nivel=3):
    if nivel > max_nivel:
        return

    try:
        # Filtrar solo directorios y omitir los que están en `carpetas_omitidas`
        directorios = [d for d in os.listdir(ruta) if os.path.isdir(os.path.join(ruta, d)) and d not in carpetas_omitidas]
    except PermissionError:
        return

    for carpeta in directorios:
        print("│   " * nivel + "├── " + carpeta)
        nueva_ruta = os.path.join(ruta, carpeta)
        
        # Si la carpeta está en `contenido_omitido`, NO listar su contenido
        if carpeta not in contenido_omitido:
            listar_directorio(nueva_ruta, nivel + 1, max_nivel)

# Ruta del proyecto (puedes cambiarla)
ruta_proyecto = os.getcwd()  # O usa una ruta absoluta como "C:\\Users\\TuUsuario\\MiProyecto"
print(ruta_proyecto)
listar_directorio(ruta_proyecto)
