#!/bin/bash

# Crear grupos
echo "Creando grupos..."
groupadd profesores
groupadd administradores
groupadd secretarios
groupadd alumnos

# Crear usuarios
echo "Creando usuarios..."
useradd -m -g profesores profesor
useradd -m -g administradores administrador
useradd -m -g secretarios secretario
useradd -m -g alumnos alumno

# Asignar contraseñas a los usuarios
echo "Asignando contraseñas a los usuarios..."
echo "profesor:profesor" | chpasswd
echo "administrador:administrador" | chpasswd
echo "secretario:secretario" | chpasswd
echo "alumno:alumno" | chpasswd

# Crear usuarios en Samba
echo "Creando usuarios en Samba..."
echo -e "profesor\nprofesor" | smbpasswd -a -s profesor
echo -e "administrador\nadministrador" | smbpasswd -a -s administrador
echo -e "secretario\nsecretario" | smbpasswd -a -s secretario
echo -e "alumno\nalumno" | smbpasswd -a -s alumno

echo "Usuarios y contraseñas creados."
echo "Usuarios y contraseñas SAMBA creados."
