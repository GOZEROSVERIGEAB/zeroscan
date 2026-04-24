<x-layouts.public title="Cookie-policy" description="Läs om hur Scanit använder cookies">
    <div class="bg-white rounded-2xl p-8 md:p-12 shadow-sm">
        <h1 class="text-3xl md:text-4xl font-bold text-[#005151] mb-2">Cookie-policy</h1>
        <p class="text-gray-500 mb-8">Senast uppdaterad: {{ date('Y-m-d') }}</p>

        <div class="prose max-w-none">
            <p>
                Denna cookie-policy förklarar vad cookies är, hur vi använder dem på Scanit och vilka val du har.
            </p>

            <h2>1. Vad är cookies?</h2>
            <p>
                Cookies är små textfiler som lagras på din enhet (dator, mobil eller surfplatta) när du besöker en webbplats. De används för att webbplatsen ska fungera, för att förbättra prestanda och för att samla in information om hur webbplatsen används.
            </p>

            <h2>2. Hur vi använder cookies</h2>
            <p>Vi använder cookies för att:</p>
            <ul>
                <li>Få Tjänsten att fungera korrekt (nödvändiga cookies)</li>
                <li>Komma ihåg dina inställningar och sessioner</li>
                <li>Förstå hur Tjänsten används för att kunna förbättra den</li>
                <li>Verifiera säkerhet (t.ex. Cloudflare Turnstile)</li>
            </ul>

            <h2>3. Typer av cookies vi använder</h2>

            <h3>Nödvändiga cookies</h3>
            <p>
                Dessa cookies är nödvändiga för att Tjänsten ska fungera och kan inte stängas av. De lagras endast som svar på dina åtgärder, t.ex. inloggning eller formulärinmatning.
            </p>

            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Cookie</th>
                            <th>Syfte</th>
                            <th>Varaktighet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>scanit_session</code></td>
                            <td>Hanterar din session i Tjänsten</td>
                            <td>2 timmar</td>
                        </tr>
                        <tr>
                            <td><code>XSRF-TOKEN</code></td>
                            <td>Skyddar mot CSRF-attacker</td>
                            <td>2 timmar</td>
                        </tr>
                        <tr>
                            <td><code>cf_clearance</code></td>
                            <td>Cloudflare säkerhetsverifiering</td>
                            <td>30 minuter</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3>Funktionella cookies</h3>
            <p>
                Dessa cookies förbättrar funktionaliteten genom att komma ihåg dina val.
            </p>

            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Cookie</th>
                            <th>Syfte</th>
                            <th>Varaktighet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>locale</code></td>
                            <td>Sparar ditt språkval</td>
                            <td>1 år</td>
                        </tr>
                        <tr>
                            <td><code>cookie_consent</code></td>
                            <td>Sparar ditt cookie-samtycke</td>
                            <td>1 år</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3>Analytiska cookies</h3>
            <p>
                Vi kan använda analytiska cookies för att förstå hur Tjänsten används. Dessa samlar in anonym information.
            </p>

            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Cookie</th>
                            <th>Syfte</th>
                            <th>Varaktighet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>_ga</code></td>
                            <td>Google Analytics - särskiljer användare</td>
                            <td>2 år</td>
                        </tr>
                        <tr>
                            <td><code>_gid</code></td>
                            <td>Google Analytics - särskiljer användare</td>
                            <td>24 timmar</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2>4. Tredjepartscookies</h2>
            <p>
                Vi använder tjänster från tredje part som kan sätta egna cookies:
            </p>
            <ul>
                <li><strong>Cloudflare</strong> – för säkerhet och prestanda</li>
                <li><strong>Google Analytics</strong> – för webbanalys (om aktiverat)</li>
            </ul>
            <p>
                Dessa tredje parter har egna integritetspolicyer som styr hur de behandlar data.
            </p>

            <h2>5. Hantera cookies</h2>
            <p>
                Du kan hantera cookies på flera sätt:
            </p>

            <h3>Via din webbläsare</h3>
            <p>
                De flesta webbläsare låter dig se, hantera och radera cookies via inställningarna:
            </p>
            <ul>
                <li><strong>Chrome:</strong> Inställningar → Sekretess och säkerhet → Cookies</li>
                <li><strong>Firefox:</strong> Inställningar → Integritet och säkerhet → Cookies</li>
                <li><strong>Safari:</strong> Inställningar → Integritet → Hantera webbplatsdata</li>
                <li><strong>Edge:</strong> Inställningar → Cookies och webbplatsbehörigheter</li>
            </ul>

            <h3>Konsekvenser av att blockera cookies</h3>
            <p>
                Om du blockerar nödvändiga cookies kan vissa funktioner i Tjänsten sluta fungera, t.ex.:
            </p>
            <ul>
                <li>Inloggning och sessioner</li>
                <li>Formulär och säkerhetskontroller</li>
                <li>Sparade inställningar</li>
            </ul>

            <h2>6. Ändringar i cookie-policyn</h2>
            <p>
                Vi kan uppdatera denna cookie-policy. Ändringar publiceras på denna sida med ett uppdaterat datum.
            </p>

            <h2>7. Kontakt</h2>
            <p>
                Har du frågor om vår användning av cookies? Kontakta oss:
            </p>
            <p>
                GoZero Sverige AB — Ett techföretag inom PreZero koncernen<br>
                Blomstergatan 6, 591 70 Motala<br>
                E-post: emilia.mastad@prezero.com eller andreas@gozero.se
            </p>
        </div>
    </div>
</x-layouts.public>
