with open(r'resources\views\prompts\index.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

# Encontrar primera línea con @endsection
idx = None
for i, line in enumerate(lines):
    if '@endsection' in line:
        idx = i
        break

# Guardar solo hasta esa línea
if idx is not None:
    with open(r'resources\views\prompts\index.blade.php', 'w', encoding='utf-8') as f:
        f.writelines(lines[:idx+1])
    print(f'Archivo limpiado: mantenidas {idx+1} líneas')
else:
    print('No se encontró @endsection')
