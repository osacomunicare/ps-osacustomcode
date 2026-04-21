# OSA Custom Code for PrestaShop

**Sviluppato da:** [OsaComunicare](https://osacomunicare.it)  
**Versione:** 3.1.0  
**Compatibilità:** PrestaShop 8.0.0+ / 9.x  
**Licenza:** Academic Free License (AFL 3.0)

## 📝 Descrizione
**OSA Custom Code** è un modulo leggero e potente per PrestaShop progettato per inserire snippet di codice personalizzati (Meta Tag, JSON-LD, CSS e JavaScript) in punti strategici del tuo e-commerce senza dover modificare i file del tema o i file core.

È lo strumento ideale per gestire Dati Strutturati SEO, Pixel di tracciamento (Facebook, Google Analytics), tag di verifica e personalizzazioni grafiche rapide.

## ✨ Caratteristiche principali
Il modulo suddivide il lavoro in **due Task principali** per una gestione ordinata:

### Task 1: Header (<head>)
- **HTML / Meta Tags:** Ideale per Verification Tags e Dati Strutturati (JSON-LD).
- **Custom CSS:** Inserimento di regole CSS (i tag `<style>` vengono aggiunti automaticamente).
- **JavaScript Head:** Script critici che devono essere caricati nell'intestazione.

### Task 2: Footer (Prima di </body>)
- **JavaScript Footer:** Script di tracking o librerie esterne.
- **HTML Footer:** Widget, chat box o banner HTML personalizzati.

## 🚀 Installazione

1. Scarica la cartella del modulo o lo zip `osacustomcode.zip`.
2. Nel pannello di amministrazione di PrestaShop, vai su **Moduli** > **Gestione Moduli**.
3. Clicca su **Carica un modulo** e trascina il file zip.
4. Clicca su **Installa** e poi su **Configura**.

## 🛠️ Come Funziona
Il modulo salva i dati nella tabella `ps_configuration` del database di PrestaShop. Utilizza gli hook nativi `displayHeader` e `displayFooter` per iniettare il codice nel front-end in modo sicuro ed efficiente, garantendo la compatibilità con la maggior parte dei temi (incluso il tema Classic e temi basati su Symfony).

## 🎨 Interfaccia Admin
L'area di configurazione dispone di un editor in **"Dark Mode"** con font monospaced per facilitare la lettura del codice e prevenire errori di sintassi. Ogni campo è espandibile e supporta lo scorrimento verticale per gestire script di grandi dimensioni.

## ⚠️ Avvertenze
- Assicurati di includere i tag `<script>` nei campi dedicati al JavaScript.
- Il campo CSS **non** richiede i tag `<style>`, verranno aggiunti dal modulo.
- Svuota la cache di PrestaShop dopo aver salvato le modifiche se non le vedi subito nel front-end.

---
*Progetto curato da OsaComunicare per la community di PrestaShop.*
