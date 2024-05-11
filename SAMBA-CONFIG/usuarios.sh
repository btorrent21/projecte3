#!/bin/bash
echo "Comenzando script de usuarios..."

# Verificar si los grupos existen
echo "Verificando grupos..."
if ! getent group administradores >/dev/null; then
    groupadd administradores
fi

if ! getent group profesores >/dev/null; then
    groupadd profesores
fi

if ! getent group alumnos >/dev/null; then
    groupadd alumnos
fi

if ! getent group secretarios >/dev/null; then
    groupadd secretarios
fi

echo "Grupos creados!"

# Verificar si los usuarios existen
echo "Verificando usuarios..."
if ! getent passwd administrador >/dev/null; then
    useradd -m -G administradores administrador
    echo "administrador:administrador" | chpasswd
    echo "Asignando contraseña Samba al administrador..."
    smbpasswd -a administrador -s <<< "administrador"
fi

if ! getent passwd profesor >/dev/null; then
    useradd -m -G profesores profesor
    echo "profesor:profesor" | chpasswd
    echo "Asignando contraseña Samba al profesor..."
    smbpasswd -a profesor -s <<< "profesor"
fi

if ! getent passwd alumno >/dev/null; then
    useradd -m -G alumnos alumno
    echo "alumno:alumno" | chpasswd
    echo "Asignando contraseña Samba al alumno..."
    smbpasswd -a alumno -s <<< "alumno"
fi

if ! getent passwd secretario >/dev/null; then
    useradd -m -G secretarios secretario
    echo "secretario:secretario" | chpasswd
    echo "Asignando contraseña Samba al secretario..."
    smbpasswd -a secretario -s <<< "secretario"
fi

echo "Usuarios y contraseñas creados."
echo "Usuarios y contraseñas SAMBA creados."

