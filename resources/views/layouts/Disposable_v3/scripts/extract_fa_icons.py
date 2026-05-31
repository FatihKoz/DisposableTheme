import re
from pathlib import Path
root = Path('.')
ignore = {'fa-2x','fa-3x','fa-lg','fa-fw','fa-sm','fa-xs','fa-inverse','fa-border','fa-pull-left','fa-pull-right','fa-spin','fa-pulse','fa-rotate-90','fa-rotate-180','fa-rotate-270','fa-flip-horizontal','fa-flip-vertical','fa-flip','fa-stack','fa-stack-1x','fa-stack-2x','fa-li'}
results = []
for path in sorted(root.rglob('*.blade.php')):
    rel = str(path.as_posix())
    with path.open('r', encoding='utf-8', errors='ignore') as f:
        for i, line in enumerate(f, start=1):
            if 'fa-' not in line:
                continue
            for match in re.finditer(r'<i[^>]*class=["\']([^"\']*)["\']', line):
                classes = match.group(1).split()
                if not any(c.startswith('fa-') or c in {'fas', 'far', 'fab', 'fal', 'fad', 'fat'} for c in classes):
                    continue
                style = next((c for c in classes if c in {'fas', 'far', 'fab', 'fal', 'fad', 'fat'}), 'fas')
                icons = [c for c in classes if c.startswith('fa-') and c not in ignore]
                if icons:
                    results.append((rel, i, style, icons, line.strip()))
            # fallback for raw strings with classes not in <i> tag
            if '<i' not in line and 'fa-' in line:
                for m in re.finditer(r'\b(fas|far|fab|fal|fad|fat)?\s*(fa-[a-z0-9-]+)\b', line):
                    style = m.group(1) or 'fas'
                    icon = m.group(2)
                    results.append((rel, i, style, [icon], line.strip()))
with open('blade-icon-classes.txt', 'w', encoding='utf-8') as out:
    for rel, i, style, icons, line in results:
        out.write(f'{rel}|{i}|{style}|{";".join(icons)}|{line}\n')
print(len(results))
