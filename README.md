OSA Custom Code for PrestaShop

Sviluppato da: OsaComunicare

Supporto: 800 911 329

Versione: 1.1.0 (DiaEvent Definitive)

Compatibilità: PrestaShop 1.7.x / 8.x / 9.x
📝 Descrizione

OSA Custom Code è lo strumento professionale definitivo per la gestione di snippet di codice personalizzati su PrestaShop. A differenza dei moduli standard, è progettato per garantire che nessun filtro di sicurezza del server o del database possa mai corrompere o eliminare i tuoi script.
🛡️ La Forza della Scelta Tecnica: File System vs Database

La maggior parte dei moduli (come HTML Box) salva il codice all'interno del database (tabella ps_configuration). Questa pratica espone il codice a rischi costanti:

    Nessuna Corruzione: Il codice non viene "pulito" o tagliato dall'HTML Purifier di PrestaShop o dai firewall SQL.

    Performance Superiori: La lettura diretta da file è estremamente più leggera per il server rispetto a una query SQL.

    Affidabilità Totale: Anche i JavaScript più complessi o i CSS con caratteri speciali vengono conservati esattamente come li hai scritti, senza bisogno di "trucchi" di codifica.

🚚 Portabilità Estrema (Easy Porting)

Uno dei vantaggi esclusivi dell'architettura a file è la semplicità con cui puoi spostare le configurazioni tra diversi siti (ad esempio da un ambiente di test a uno di produzione):

    Copia i file: Vai nella cartella /modules/osacustomcode/code/ del primo sito.

    Incolla i file: Copia i file .txt (es. head_js.txt, css_global.txt) nella stessa cartella del secondo sito.

    Pronto all'uso: Il secondo sito applicherà immediatamente tutte le direttive, a patto che il modulo OSA Custom Code sia installato. Non dovrai più ricopiare manualmente il codice campo per campo.

✨ Caratteristiche principali

L'interfaccia è suddivisa in tre sezioni ottimizzate con il Verde OSA (#5F8C5E):
1. CSS

    Finestra dedicata esclusivamente alle direttive estetiche.

    Iniezione automatica nel tag <style> in modo trasparente.

2. HEADER

    HTML/Meta: Ideale per Verification Tags, JSON-LD e Meta Tag SEO.

    JavaScript: Finestra separata per script che devono risiedere obbligatoriamente nel <head>.

3. BODY / FOOTER

    HTML: Per widget o elementi visivi a fine pagina.

    JavaScript: Perfetto per Pixel di tracciamento (Facebook, Google Analytics) da caricare prima della chiusura del tag </body>.

🚀 Installazione e Manutenzione

    Carica la cartella osacustomcode nella directory /modules/ del tuo PrestaShop.

    Installa il modulo dal backoffice.

    Permessi: Assicurati che la cartella /code/ all'interno del modulo abbia i permessi di scrittura (CHMOD 755 o 775) per permettere il salvataggio dei file.

🛠️ Note Tecniche

Il modulo utilizza gli hook nativi per la massima compatibilità:

    displayHeader: per CSS e Header Code.

    displayFooter: per l'iniezione nel Body.

    displayBackOfficeHeader: per l'interfaccia brandizzata OSA.

OsaComunicare - Diamo forza alle tue idee con soluzioni tecniche senza compromessi.
