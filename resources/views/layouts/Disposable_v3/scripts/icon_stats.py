from collections import Counter
from pathlib import Path
root = Path('.')
ignore = {'fa-2x','fa-3x','fa-lg','fa-fw','fa-sm','fa-xs','fa-inverse','fa-border','fa-pull-left','fa-pull-right','fa-spin','fa-pulse','fa-rotate-90','fa-rotate-180','fa-rotate-270','fa-flip-horizontal','fa-flip-vertical','fa-flip','fa-stack','fa-stack-1x','fa-stack-2x','fa-li'}
counts = Counter()
styles = {}
for path in sorted(root.rglob('*.blade.php')):
    with path.open('r', encoding='utf-8', errors='ignore') as f:
        for line in f:
            if 'fa-' not in line:
                continue
            for part in line.split('class='):
                if 'fa-' not in part:
                    continue
                if part[0] not in '"\'':
                    continue
                end = part.find(part[0], 1)
                if end == -1:
                    continue
                s = part[1:end]
                classes = s.split()
                style = next((c for c in classes if c in {'fas','far','fab','fal','fad','fat'}), 'fas')
                for c in classes:
                    if c.startswith('fa-') and c not in ignore:
                        counts[c] += 1
                        if c not in styles:
                            styles[c] = style
for icon, count in counts.most_common():
    print(f'{icon}|{styles.get(icon,"fas")}|{count}')
