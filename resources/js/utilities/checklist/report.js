/**
 * Html report of the frontend checklist: summary, results per item, screenshots of the breakpoints
 * (for the visual review) and links to the Lighthouse reports
 */
import { writeFile } from "fs/promises";

const statusLabels = { pass: "✓ ok", warn: "⚠ aviso", fail: "✗ falha" };

const escapeHtml = (text) =>
    String(text)
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;");

function renderResult({ target, status, details, report, screenshots }) {
    const detailsList =
        details.length > 0
            ? `<ul>${details.map((detail) => `<li>${escapeHtml(detail)}</li>`).join("")}</ul>`
            : "";

    const reportLink = report
        ? `<p><a href="${report}">Relatório do Lighthouse</a></p>`
        : "";

    const gallery = screenshots
        ? `<p class="hint">Revisão visual: sobreposição, texto cortado, espaçamento</p>
           <div class="gallery">${screenshots
               .map(
                   ({ file, width, hasOverflow }) => `
                <a href="${file}" class="shot${hasOverflow ? " has-overflow" : ""}">
                    <img src="${file}" alt="${escapeHtml(target)} em ${width}px" loading="lazy" />
                    <span>${width}px</span>
                </a>`,
               )
               .join("")}</div>`
        : "";

    return `
        <article class="result ${status}">
            <h3><span class="badge">${statusLabels[status]}</span> ${escapeHtml(target)}</h3>
            ${detailsList}${reportLink}${gallery}
        </article>`;
}

function renderItem(item, results) {
    return `
        <section>
            <h2>${escapeHtml(item)}</h2>
            ${results.map(renderResult).join("")}
        </section>`;
}

export default async function writeReport(results, { baseUrl, reportFolder }) {
    const items = [...new Set(results.map(({ item }) => item))];
    const count = (status) =>
        results.filter((result) => result.status === status).length;
    const generatedAt = new Date().toLocaleString("pt-BR");

    const html = `<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checklist de frontend</title>
    <style>
        :root { color-scheme: light dark; --bg: #fff; --fg: #1d1d1f; --muted: #6b6b70; --line: #e3e3e6;
            --pass: #1a7f37; --warn: #9a6700; --fail: #cf222e; }
        @media (prefers-color-scheme: dark) {
            :root { --bg: #161618; --fg: #ececef; --muted: #a0a0a8; --line: #2e2e33;
                --pass: #4ac26b; --warn: #d4a72c; --fail: #ff6b6b; }
        }
        body { margin: 0; padding: 24px 16px 64px; background: var(--bg); color: var(--fg);
            font: 15px/1.5 system-ui, sans-serif; }
        main { max-width: 1100px; margin: 0 auto; }
        h1 { margin: 0 0 4px; font-size: 24px; }
        h2 { margin: 40px 0 12px; font-size: 18px; border-bottom: 1px solid var(--line); padding-bottom: 6px; }
        h3 { margin: 0; font-size: 15px; font-weight: 600; overflow-wrap: anywhere; }
        .meta, .hint { color: var(--muted); font-size: 13px; }
        .summary { display: flex; flex-wrap: wrap; gap: 16px; margin-top: 12px; font-weight: 600; }
        .summary .pass, .result.pass .badge { color: var(--pass); }
        .summary .warn, .result.warn .badge { color: var(--warn); }
        .summary .fail, .result.fail .badge { color: var(--fail); }
        .result { padding: 12px 0; border-bottom: 1px solid var(--line); }
        .result ul { margin: 6px 0 0; padding-left: 20px; font-size: 14px; overflow-wrap: anywhere; }
        .badge { margin-right: 6px; }
        .gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; }
        .shot { display: block; color: inherit; text-decoration: none; font-size: 13px; text-align: center; }
        .shot img { display: block; width: 100%; height: 220px; object-fit: cover; object-position: top;
            border: 1px solid var(--line); border-radius: 6px; }
        .shot.has-overflow img { border: 2px solid var(--fail); }
        a { color: inherit; }
    </style>
</head>
<body>
<main>
    <h1>Checklist de frontend</h1>
    <p class="meta">${escapeHtml(baseUrl)} · ${escapeHtml(generatedAt)}</p>
    <div class="summary">
        <span class="pass">${count("pass")} ok</span>
        <span class="warn">${count("warn")} avisos</span>
        <span class="fail">${count("fail")} falhas</span>
    </div>
    ${items
        .map((item) =>
            renderItem(
                item,
                results.filter((result) => result.item === item),
            ),
        )
        .join("")}
</main>
</body>
</html>`;

    const file = `${reportFolder}/index.html`;

    await writeFile(file, html);

    return file;
}
