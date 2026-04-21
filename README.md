# OSA Custom Code for PrestaShop

**Sviluppato da:** [OsaComunicare](https://osacomunicare.it)  
**Supporto:** 800 911 329  
**Versione:** 1.1.0  
**Compatibilità:** PrestaShop 8.x / 9.x  
**Licenza:** Academic Free License (AFL 3.0)

## 📝 Descrizione
**OSA Custom Code** è un modulo professionale per PrestaShop progettato per la gestione centralizzata di snippet di codice personalizzati. Permette di iniettare CSS, Meta Tag e JavaScript in punti strategici del sito senza modificare i file del tema o il core di PrestaShop.

L'interfaccia è stata progettata per essere pulita, ordinata e intuitiva, seguendo l'identità visiva di OsaComunicare.

## ✨ Caratteristiche principali

L'amministrazione è suddivisa in tre sezioni (Tab) indipendenti per evitare confusione tra codice estetico, funzionale e di tracciamento:

### 1. CSS
- **Personalizzazioni Globali:** Una finestra dedicata esclusivamente alle direttive CSS.
- **Iniezione Automatica:** Il modulo avvolge il codice nel tag `<style>` in modo trasparente.

### 2. HEADER
- **Codice Personalizzato (HTML/Meta):** Ideale per Verification Tags, Dati Strutturati (JSON-LD) e Meta Tag SEO.
- **Script Java:** Finestra separata per JavaScript che deve essere caricato nel `<head>`.

### 3. BODY
- **Codice Personalizzato (HTML):** Inserimento di widget o elementi HTML a fine pagina.
- **Script Java:** Ideale per Pixel di tracciamento (Facebook, Google Analytics) e script asincroni da caricare prima della chiusura del tag `</body>`.

## 🎨 Interfaccia "Osa Style"
- **Design Pulito:** Finestre di editing chiare (Light Mode) per una migliore leggibilità.
- **Focus Visivo:** Barra laterale e accenti cromatici in Verde OSA (`#5F8C5E`).
- **Editor Avanzato:** Supporto per font monospaced e barre di scorrimento laterali per gestire lunghe porzioni di codice.

## 🚀 Installazione

1. Crea uno zip della cartella chiamato `osacustomcode.zip`.
2. Assicurati che la cartella principale interna si chiami esattamente `osacustomcode`.
3. Nel pannello di amministrazione di PrestaShop, vai su **Moduli** > **Gestione Moduli**.
4. Clicca su **Carica un modulo** e trascina il file zip.
5. Clicca su **Installa** e poi su **Configura**.

## 🛠️ Note Tecniche
Il modulo utilizza gli hook nativi di PrestaShop:
- `displayHeader`: per l'iniezione del CSS e del codice dell'Header.
- `displayFooter`: per l'iniezione del codice nel Body (fine pagina).
- `displayBackOfficeHeader`: per la personalizzazione estetica dell'area di configurazione.

I dati vengono salvati in modo sicuro nella tabella `ps_configuration`, garantendo la persistenza anche durante gli aggiornamenti del tema.

---
*Powered by OsaComunicare - Esperti in comunicazione e sviluppo e-commerce.*
