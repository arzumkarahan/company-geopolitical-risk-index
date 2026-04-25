echo <<<'CGRI_END'
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Company Geopolitical Risk Index</title>
<!-- Chart.js loaded dynamically in script below -->
<style>
/* ── Reset & base ── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
#cgri-widget{font-family:Arial,Helvetica,sans-serif;color:#1a1a1a;background:#f5f5f5;max-width:1200px;margin:0 auto}

/* ── Tab bar ── */
.cgri-tabs{display:flex;background:#E8601A;border-bottom:3px solid #c44e10}
.cgri-tab{flex:1;padding:14px 10px;text-align:center;cursor:pointer;color:rgba(255,255,255,0.75);font-weight:600;font-size:0.9rem;letter-spacing:0.02em;border:none;background:transparent;transition:all .2s}
.cgri-tab:hover{color:#fff;background:rgba(0,0,0,0.1)}
.cgri-tab.active{color:#fff;background:#c44e10;border-bottom:3px solid #fff}

/* ── Page ── */
.cgri-page{display:none;padding:24px}
.cgri-page.active{display:block}

/* ── Cards ── */
.kpi-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
.kpi-card{background:#fff;border-radius:10px;padding:16px 18px;box-shadow:0 2px 8px rgba(0,0,0,0.07);border-left:4px solid #E8601A}
.kpi-label{font-size:0.68rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:0.06em}
.kpi-value{font-size:1.7rem;font-weight:700;color:#1a1a1a;line-height:1.1;margin-top:2px}
.kpi-sub{font-size:0.73rem;color:#aaa;margin-top:2px}

/* ── Section headers ── */
.section-title{font-size:1rem;font-weight:700;color:#1a1a1a;margin:22px 0 12px;padding-bottom:6px;border-bottom:2px solid #E8601A;display:inline-block}

/* ── Chart containers ── */
.chart-box{background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.07);margin-bottom:20px}
.chart-box canvas{max-height:380px}

/* ── Two-col layout ── */
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}

/* ── Table ── */
.table-wrap{background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);overflow:auto;margin-bottom:20px}
table{width:100%;border-collapse:collapse;font-size:0.83rem}
thead th{background:#E8601A;color:#fff;padding:10px 12px;text-align:left;white-space:nowrap;cursor:pointer;user-select:none}
thead th:hover{background:#c44e10}
tbody tr:nth-child(even){background:#fafafa}
tbody tr:hover{background:#fff3ee}
tbody td{padding:9px 12px;border-bottom:1px solid #eee;white-space:nowrap}
.risk-badge{display:inline-block;padding:2px 8px;border-radius:12px;font-weight:700;font-size:0.75rem}
.risk-Low{background:#d6f5e3;color:#1a6b3c}
.risk-Moderate{background:#fef3d8;color:#7a5000}
.risk-High{background:#fde8d5;color:#7a3000}
.risk-Very.High{background:#fad7d5;color:#7a1010}

/* ── Filters ── */
.filter-row{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px;align-items:center}
.filter-row select,.filter-row input{padding:7px 10px;border:1px solid #ddd;border-radius:6px;font-size:0.83rem;background:#fff}
.filter-row label{font-size:0.8rem;color:#555;font-weight:600}

/* ── Calculator ── */
.calc-section{background:#fff;border-radius:10px;padding:22px;box-shadow:0 2px 8px rgba(0,0,0,0.07);margin-bottom:20px}
.calc-section h3{font-size:1rem;font-weight:700;color:#E8601A;margin-bottom:16px}
.profile-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.form-group{display:flex;flex-direction:column;gap:4px}
.form-group label{font-size:0.75rem;font-weight:700;color:#555;text-transform:uppercase;letter-spacing:0.04em}
.form-group input,.form-group select{padding:9px 10px;border:1px solid #ddd;border-radius:6px;font-size:0.85rem;width:100%}
.form-group input:focus,.form-group select:focus{outline:2px solid #E8601A;border-color:#E8601A}
.lev-hint{font-size:0.75rem;color:#E8601A;font-weight:600;margin-top:4px}

/* ── Exposure panels ── */
.exposure-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.exp-panel{background:#f9f9f9;border:1px solid #eee;border-radius:10px;padding:14px}
.exp-panel-head{font-size:0.82rem;font-weight:700;color:#1a1a1a;margin-bottom:10px;display:flex;align-items:center;gap:8px}
.exp-panel-num{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;background:#E8601A;color:#fff;border-radius:50%;font-size:0.7rem;font-weight:700;flex-shrink:0}
.exp-col-labels{display:grid;grid-template-columns:1fr 80px 58px 52px 28px;gap:6px;padding:0 6px 4px;border-bottom:1px solid #ddd;margin-bottom:6px}
.exp-col-labels span{font-size:0.65rem;font-weight:700;color:#999;text-transform:uppercase;letter-spacing:0.04em}
.exp-rows{display:flex;flex-direction:column;gap:5px;margin-bottom:8px}
.exp-row{display:grid;grid-template-columns:1fr 80px 58px 52px 28px;gap:6px;align-items:center;background:#fff;border:1px solid #eee;border-radius:7px;padding:6px;transition:border-color .15s}
.exp-row:hover{border-color:#E8601A55;background:#fffaf8}
.exp-row select{padding:5px 6px;border:1px solid #ddd;border-radius:5px;font-size:0.78rem;background:#fff;width:100%;min-width:0}
.exp-row select:focus{outline:2px solid #E8601A;border-color:#E8601A}
.exp-row input[type=number]{padding:5px 6px;border:1px solid #ddd;border-radius:5px;font-size:0.78rem;text-align:right;width:100%}
.exp-row input:focus{outline:2px solid #E8601A;border-color:#E8601A}
.share-pill{font-size:0.72rem;font-weight:700;padding:2px 6px;border-radius:10px;text-align:center;background:#E8601A;color:#fff;white-space:nowrap}
.share-pill.empty{background:#eee;color:#aaa}
.gri-tag{font-size:0.68rem;color:#888;text-align:center;white-space:nowrap}
.btn-del-row{background:none;border:none;color:#ccc;cursor:pointer;font-size:0.9rem;padding:2px;display:flex;align-items:center;justify-content:center}
.btn-del-row:hover{color:#e74c3c}
.btn-add{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:#fff;border:1px dashed #ddd;border-radius:6px;cursor:pointer;font-size:0.78rem;font-weight:600;color:#888;transition:all .15s}
.btn-add:hover{background:#fff3ee;border-color:#E8601A;color:#E8601A}

/* ── Radar toggle ── */
.radar-toggle-row{display:flex;align-items:center;gap:8px;margin-top:8px}
.tog-switch{position:relative;width:34px;height:18px;flex-shrink:0}
.tog-switch input{opacity:0;width:0;height:0;position:absolute}
.tog-slider{position:absolute;cursor:pointer;inset:0;background:#ccc;border-radius:18px;transition:.2s}
.tog-slider::before{content:'';position:absolute;width:12px;height:12px;left:3px;top:3px;background:#fff;border-radius:50%;transition:.2s}
.tog-switch input:checked+.tog-slider{background:#E8601A}
.tog-switch input:checked+.tog-slider::before{transform:translateX(16px)}
.tog-label{font-size:0.76rem;color:#555;font-weight:600}
.btn-compute{display:block;width:100%;padding:14px;background:#E8601A;color:#fff;border:none;border-radius:8px;font-size:1rem;font-weight:700;cursor:pointer;letter-spacing:0.04em;margin-top:8px;transition:background .2s}
.btn-compute:hover{background:#c44e10}

/* ── Results ── */
#calc-results{margin-top:24px;display:none}
.score-card{background:linear-gradient(135deg,#E8601A,#c44e10);border-radius:12px;padding:24px;text-align:center;color:#fff;margin-bottom:20px}
.score-num{font-size:3rem;font-weight:800;line-height:1}
.score-cat{font-size:1.1rem;opacity:0.9;margin-top:6px}
.score-co{font-size:0.85rem;opacity:0.7;margin-top:4px}
.score-card.Low{background:linear-gradient(135deg,#27ae60,#1e8449)}
.score-card.Moderate{background:linear-gradient(135deg,#f39c12,#d68910)}
.score-card.High{background:linear-gradient(135deg,#e67e22,#ca6f1e)}
.score-card.Very-High{background:linear-gradient(135deg,#e74c3c,#cb4335)}
.comp-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
.comp-card{background:#fff;border-radius:8px;padding:14px;box-shadow:0 1px 5px rgba(0,0,0,0.07);text-align:center}
.comp-card .cv{font-size:1.4rem;font-weight:700;color:#1a1a1a}
.comp-card .cl{font-size:0.68rem;color:#888;font-weight:700;text-transform:uppercase;letter-spacing:0.05em}
.comp-card .cd{font-size:0.7rem;color:#bbb;margin-top:2px}

/* ── Methodology ── */
.method-intro{background:#fff;border-radius:10px;padding:18px 22px;box-shadow:0 2px 8px rgba(0,0,0,0.07);margin-bottom:20px;font-size:0.85rem;color:#555;line-height:1.7;border-left:4px solid #E8601A}
.method-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.method-box{background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,0.07)}
.method-box h3{font-size:0.88rem;font-weight:700;color:#E8601A;margin-bottom:12px;padding-bottom:8px;border-bottom:2px solid #fde8d5;display:flex;align-items:center;gap:6px}
.method-box p,.method-box li{font-size:0.83rem;color:#444;line-height:1.65}
.method-box ul{padding-left:18px;margin-top:6px}
.method-box ul li{margin-bottom:4px}
.formula-box{background:#1e1e2e;border-radius:10px;padding:20px 22px;margin-bottom:20px;font-family:'Courier New',monospace;font-size:0.83rem;color:#cdd6f4;line-height:2;overflow-x:auto;border:1px solid #313244}
.formula-box span{color:#fab387;font-weight:700}
.formula-box .f-label{color:#89b4fa}
.mtable{width:100%;border-collapse:collapse;font-size:0.8rem;margin-top:8px}
.mtable thead tr{background:#fdf2ee}
.mtable th{padding:8px 10px;text-align:left;font-weight:700;color:#E8601A;background:#fdf2ee;border-bottom:2px solid #fad7c5;font-size:0.75rem;text-transform:uppercase;letter-spacing:0.03em;cursor:default;user-select:none}
.mtable td{padding:7px 10px;border-bottom:1px solid #f0f0f0;color:#333;font-size:0.82rem}
.mtable tr:hover td{background:#fffaf8}
.mtable tr:last-child td{border-bottom:none}
.mtable td b{color:#E8601A}
.weight-badge{display:inline-block;padding:2px 8px;border-radius:10px;background:#fde8d5;color:#E8601A;font-weight:700;font-size:0.78rem}
.source-list{display:flex;flex-direction:column;gap:10px;margin-top:10px}
.source-item{display:flex;gap:10px;align-items:flex-start;padding:10px;background:#fafafa;border-radius:7px;border:1px solid #eee}
.source-icon{font-size:1rem;flex-shrink:0;margin-top:1px}
.source-text{font-size:0.82rem;color:#444;line-height:1.5}
.source-text b{color:#1a1a1a}

/* ── Radar select ── */
.radar-controls{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:8px;align-items:center}
.radar-controls label{font-size:0.78rem;font-weight:700;color:#555}
.radar-controls select{padding:6px 8px;border:1px solid #ddd;border-radius:6px;font-size:0.8rem}

/* ── Alert ── */
.alert{padding:12px 16px;border-radius:8px;font-size:0.85rem;margin-bottom:16px}
.alert-warn{background:#fff3cd;border:1px solid #ffc107;color:#856404}
.alert-err{background:#f8d7da;border:1px solid #f5c6cb;color:#721c24}

/* ── Responsive ── */
@media(max-width:768px){
  .kpi-row{grid-template-columns:1fr 1fr}
  .profile-grid{grid-template-columns:1fr 1fr}
  .exposure-grid{grid-template-columns:1fr}
  .two-col{grid-template-columns:1fr}
  .comp-cards{grid-template-columns:1fr 1fr}
  .method-grid{grid-template-columns:1fr}
  .cgri-tab{font-size:0.75rem;padding:10px 6px}
  .exp-col-labels{grid-template-columns:1fr 70px 50px 0 28px}
  .exp-col-labels span:nth-child(4){display:none}
  .exp-row{grid-template-columns:1fr 70px 50px 0 28px}
  .exp-row .gri-tag{display:none}
}
@media(max-width:480px){
  .kpi-row{grid-template-columns:1fr}
  .profile-grid{grid-template-columns:1fr}
  .comp-cards{grid-template-columns:1fr}
  .exp-col-labels{grid-template-columns:1fr 65px 46px}
  .exp-col-labels span:nth-child(4),.exp-col-labels span:nth-child(5){display:none}
  .exp-row{grid-template-columns:1fr 65px 46px}
  .exp-row .gri-tag,.exp-row .btn-del-row{display:none}
}
</style>
</head>
<body>
<div id="cgri-widget">

  <!-- Tab bar -->
  <div class="cgri-tabs">
    <button class="cgri-tab active" onclick="showTab('dashboard')">📊 Benchmark Dashboard</button>
    <button class="cgri-tab" onclick="showTab('calculator')">🧮 Custom Calculator</button>
    <button class="cgri-tab" onclick="showTab('methodology')">ℹ Methodology</button>
  </div>

  <!-- ═══════════════════════════════════════════════════════ DASHBOARD -->
  <div id="tab-dashboard" class="cgri-page active">

    <div class="kpi-row" id="kpi-row"></div>

    <div class="filter-row">
      <label>Risk:</label>
      <select id="f-risk" onchange="applyFilters()">
        <option value="">All categories</option>
        <option>Low</option><option>Moderate</option><option>High</option><option>Very High</option>
      </select>
      <label>Sector:</label>
      <select id="f-sector" onchange="applyFilters()"></select>
      <label>Sort:</label>
      <select id="f-sort" onchange="applyFilters()">
        <option value="desc">Highest first</option>
        <option value="asc">Lowest first</option>
      </select>
    </div>

    <div class="chart-box">
      <div class="section-title">CGRI Score — Ranked Portfolio</div>
      <canvas id="barChart"></canvas>
    </div>

    <div class="two-col">
      <div class="chart-box">
        <div class="section-title">Risk Dimension Radar</div>
        <div class="radar-controls">
          <label>Companies:</label>
          <select id="radar-select" multiple size="4" style="height:80px;min-width:180px" onchange="updateRadar()"></select>
        </div>
        <div class="radar-toggle-row">
          <label class="tog-switch">
            <input type="checkbox" id="radar-expanded" onchange="updateRadar()"/>
            <span class="tog-slider"></span>
          </label>
          <span class="tog-label">Expanded view (+ Financial &amp; Sector multipliers)</span>
        </div>
        <canvas id="radarChart"></canvas>
      </div>
      <div class="chart-box">
        <div class="section-title">Weighted Component Breakdown</div>
        <canvas id="stackChart"></canvas>
      </div>
    </div>

    <div class="section-title">Full Data Table</div>
    <div class="table-wrap">
      <table id="bench-table">
        <thead>
          <tr>
            <th onclick="sortTable('company')">Company ⇅</th>
            <th onclick="sortTable('sector')">Sector ⇅</th>
            <th onclick="sortTable('cgri')">CGRI ⇅</th>
            <th>Risk</th>
            <th onclick="sortTable('hq_risk')">HQ Risk ⇅</th>
            <th onclick="sortTable('revenue')">Revenue Exp. ⇅</th>
            <th onclick="sortTable('supply_chain')">Supply Chain ⇅</th>
            <th onclick="sortTable('fin_mult')">Fin. Mult. ⇅</th>
            <th onclick="sortTable('sec_mult')">Sec. Mult. ⇅</th>
          </tr>
        </thead>
        <tbody id="bench-tbody"></tbody>
      </table>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════ CALCULATOR -->
  <div id="tab-calculator" class="cgri-page">

    <div class="calc-section">
      <h3>Step 1 — Company Profile</h3>
      <div class="profile-grid">
        <div class="form-group">
          <label>Company Name</label>
          <input type="text" id="c-name" value="My Company"/>
        </div>
        <div class="form-group">
          <label>HQ Country</label>
          <select id="c-country"></select>
        </div>
        <div class="form-group">
          <label>Sector (S&amp;P Global)</label>
          <select id="c-sector"></select>
        </div>
        <div class="form-group">
          <label>Net Debt / EBITDA</label>
          <input type="number" id="c-leverage" value="1.0" step="0.1"/>
          <div class="lev-hint" id="lev-hint">Financial multiplier: ×0.9</div>
        </div>
      </div>
    </div>

    <div class="calc-section">
      <h3>Step 2 — Geographic Exposure</h3>
      <p style="font-size:0.82rem;color:#666;margin-bottom:16px">Enter any unit (%, USD mn, count). Weights are auto-normalised to 100%. Rows with zero or blank country are ignored.</p>
      <div class="exposure-grid">
        <div class="exp-panel">
          <div class="exp-panel-head"><span class="exp-panel-num">1</span>Revenue by Country</div>
          <div class="exp-col-labels"><span>Country</span><span>Weight</span><span>Share</span><span>GRI</span><span></span></div>
          <div id="rev-rows" class="exp-rows"></div>
          <button class="btn-add" onclick="addRow('rev')">+ Add country</button>
        </div>
        <div class="exp-panel">
          <div class="exp-panel-head"><span class="exp-panel-num">2</span>Supplier Domiciles</div>
          <div class="exp-col-labels"><span>Country</span><span>Weight</span><span>Share</span><span>GRI</span><span></span></div>
          <div id="sup-rows" class="exp-rows"></div>
          <button class="btn-add" onclick="addRow('sup')">+ Add country</button>
        </div>
        <div class="exp-panel">
          <div class="exp-panel-head"><span class="exp-panel-num">3</span>Supplier Facility Domiciles</div>
          <div class="exp-col-labels"><span>Country</span><span>Weight</span><span>Share</span><span>GRI</span><span></span></div>
          <div id="supfac-rows" class="exp-rows"></div>
          <button class="btn-add" onclick="addRow('supfac')">+ Add country</button>
        </div>
      </div>
    </div>

    <div class="calc-section">
      <h3>Step 3 — Compute</h3>
      <div id="calc-alert"></div>
      <button class="btn-compute" onclick="computeCGRI()">Compute CGRI Score</button>
    </div>

    <div id="calc-results">
      <div class="two-col" style="align-items:start">
        <div id="score-box"></div>
        <div class="comp-cards" id="comp-cards"></div>
      </div>
      <div class="two-col">
        <div class="chart-box">
          <div class="section-title">Risk Profile vs Benchmark Average</div>
          <canvas id="calcRadar"></canvas>
        </div>
        <div class="chart-box">
          <div class="section-title">Ranking vs Benchmark Portfolio</div>
          <canvas id="calcBar"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- ═══════════════════════════════════════════════════════ METHODOLOGY -->
  <div id="tab-methodology" class="cgri-page">

    <div class="method-intro">
      The <b>Company Geopolitical Risk Index (CGRI)</b> quantifies a firm's exposure to geopolitical risk across its headquarters location, revenue geography, and supply chain footprint. Three core components are combined with sector, volatility, and financial leverage adjustments.
    </div>

    <div class="formula-box">
      <span class="f-label">CGRI</span> = ( <span>0.20</span> × HQ_Risk &nbsp;+&nbsp; <span>0.40</span> × Revenue_Exposure &nbsp;+&nbsp; <span>0.40</span> × Supply_Chain )<br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;× <span>Sector_Multiplier</span> &nbsp;×&nbsp; <span>Volatility_Multiplier</span> &nbsp;×&nbsp; <span>Financial_Leverage_Multiplier</span>
    </div>

    <div class="method-grid">
      <div class="method-box">
        <h3>📐 Main Components</h3>
        <table class="mtable">
          <thead><tr><th>Component</th><th>Weight</th><th>Formula</th></tr></thead>
          <tbody>
            <tr><td><b>HQ Country Risk</b></td><td><span class="weight-badge">20%</span></td><td>GRI score of headquarters country</td></tr>
            <tr><td><b>Revenue Exposure</b></td><td><span class="weight-badge">40%</span></td><td>Σ(GRI_c × rev_share_c) × HHI_sub</td></tr>
            <tr><td><b>Supply Chain</b></td><td><span class="weight-badge">40%</span></td><td>(0.5 × Supplier_GRI + 0.5 × Facility_GRI) × HHI_sub</td></tr>
          </tbody>
        </table>
      </div>
      <div class="method-box">
        <h3>🔗 HHI Concentration Submultiplier</h3>
        <p style="margin-bottom:8px">The Herfindahl–Hirschman Index adjusts for geographic concentration of revenue or supply chain.</p>
        <table class="mtable">
          <thead><tr><th>HHI Range</th><th>Multiplier</th><th>Interpretation</th></tr></thead>
          <tbody>
            <tr><td>&lt; 0.15</td><td><b>0.90</b></td><td>Highly diversified</td></tr>
            <tr><td>0.15 – 0.25</td><td><b>1.00</b></td><td>Moderate</td></tr>
            <tr><td>0.25 – 0.40</td><td><b>1.10</b></td><td>Somewhat concentrated</td></tr>
            <tr><td>0.40 – 0.60</td><td><b>1.25</b></td><td>Concentrated</td></tr>
            <tr><td>≥ 0.60</td><td><b>1.50</b></td><td>Highly concentrated</td></tr>
          </tbody>
        </table>
      </div>
      <div class="method-box">
        <h3>💳 Financial Leverage Multiplier</h3>
        <p style="margin-bottom:8px">Net Debt / EBITDA ratio adjusts the base score to reflect financial resilience.</p>
        <table class="mtable">
          <thead><tr><th>Net Debt / EBITDA</th><th>Multiplier</th><th>Rationale</th></tr></thead>
          <tbody>
            <tr><td>&lt; 0 (net cash)</td><td><b>0.8</b></td><td>Very low financial risk</td></tr>
            <tr><td>0 – &lt; 2</td><td><b>0.9</b></td><td>Low leverage</td></tr>
            <tr><td>2 – &lt; 4</td><td><b>1.0</b></td><td>Moderate leverage</td></tr>
            <tr><td>4 – &lt; 6</td><td><b>1.1</b></td><td>High leverage</td></tr>
            <tr><td>≥ 6</td><td><b>1.2</b></td><td>Very high leverage</td></tr>
          </tbody>
        </table>
      </div>
      <div class="method-box">
        <h3>🏷️ Risk Categories &amp; Sector Multiplier</h3>
        <table class="mtable" style="margin-bottom:14px">
          <thead><tr><th>CGRI Score</th><th>Category</th></tr></thead>
          <tbody>
            <tr><td>&lt; 3.5</td><td><span style="color:#27ae60;font-weight:700">● Low</span></td></tr>
            <tr><td>3.5 – 5.0</td><td><span style="color:#f39c12;font-weight:700">● Moderate</span></td></tr>
            <tr><td>5.0 – 6.5</td><td><span style="color:#e67e22;font-weight:700">● High</span></td></tr>
            <tr><td>≥ 6.5</td><td><span style="color:#e74c3c;font-weight:700">● Very High</span></td></tr>
          </tbody>
        </table>
        <p><b>Sector Multiplier</b> — Derived from S&amp;P Global Industry Risk Assessment. Ranges from <b style="color:#27ae60">0.75</b> (very low risk sectors, e.g. regulated utilities) to <b style="color:#e67e22">1.25</b> (very high risk sectors).</p>
      </div>
      <div class="method-box" style="grid-column:1/-1">
        <h3>📚 Data Sources</h3>
        <div class="source-list">
          <div class="source-item"><span class="source-icon">🌍</span><div class="source-text"><b>Country GRI Scores</b> — 147 countries · geopriskindex.com · 2024 edition</div></div>
          <div class="source-item"><span class="source-icon">🏭</span><div class="source-text"><b>Sector Multipliers</b> — S&amp;P Global Industry Risk Assessment · 54 industry sectors across 6 risk tiers</div></div>
          <div class="source-item"><span class="source-icon">📈</span><div class="source-text"><b>Volatility Multiplier</b> — CBOE VIX annual average (FRED) · 2024 average = <b>0.9348</b></div></div>
          <div class="source-item"><span class="source-icon">🏢</span><div class="source-text"><b>Benchmark Company Data</b> — 25 global companies · Bloomberg financial data · 2024 fiscal year</div></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// ═══════════════════════════════════════════════════════════════════════════
// DATA
// ═══════════════════════════════════════════════════════════════════════════
const DATA = {"countries": {"Albania": 4.37, "Algeria": 5.21, "Angola": 5.63, "Argentina": 4.36, "Armenia": 4.79, "Australia": 3.22, "Austria": 3.41, "Azerbaijan": 5.21, "Bahrain": 4.26, "Bangladesh": 6.29, "Belarus": 5.45, "Belgium": 3.33, "Benin": 6.0, "Bhutan": 5.02, "Bolivia": 5.41, "Bosnia and Herzegovina": 5.34, "Botswana": 4.34, "Brazil": 5.35, "Bulgaria": 4.43, "Burkina Faso": 6.55, "Burundi": 6.33, "Cambodia": 5.64, "Cameroon": 6.83, "Canada": 3.44, "Central African Republic": 6.79, "Chad": 6.84, "Chile": 4.36, "China": 4.26, "Colombia": 5.72, "Congo, Rep.": 5.65, "Costa Rica": 4.23, "Cote d'Ivoire": 5.6, "Croatia": 4.28, "Cyprus": 4.67, "Czech Republic": 3.75, "Denmark": 3.2, "Djibouti": 5.98, "Dominican Republic": 4.7, "Ecuador": 5.71, "Egypt": 5.6, "El Salvador": 4.79, "Estonia": 3.57, "Eswatini": 4.5, "Ethiopia": 6.93, "Finland": 3.35, "France": 3.65, "Gabon": 5.78, "Gambia": 5.38, "Georgia": 4.93, "Germany": 3.42, "Ghana": 4.63, "Greece": 4.34, "Guatemala": 5.45, "Guinea": 6.36, "Guinea-Bissau": 5.94, "Guyana": 4.92, "Haiti": 6.53, "Honduras": 5.77, "Hungary": 3.63, "Iceland": 3.38, "India": 5.07, "Indonesia": 4.92, "Iran": 5.88, "Iraq": 6.05, "Ireland": 3.25, "Israel": 4.61, "Italy": 3.84, "Jamaica": 4.75, "Japan": 3.38, "Jordan": 5.13, "Kazakhstan": 4.54, "Kenya": 6.13, "Kuwait": 4.3, "Kyrgyz Republic": 5.37, "Laos": 5.14, "Latvia": 3.97, "Lebanon": 6.12, "Lesotho": 5.49, "Liberia": 5.97, "Libya": 5.68, "Lithuania": 3.93, "Madagascar": 5.82, "Malawi": 5.58, "Malaysia": 4.03, "Mali": 7.1, "Mauritania": 6.28, "Mauritius": 3.47, "Mexico": 5.42, "Moldova": 5.14, "Mongolia": 4.65, "Morocco": 5.1, "Mozambique": 6.3, "Namibia": 4.64, "Nepal": 5.78, "Netherlands": 3.59, "New Zealand": 3.32, "Nicaragua": 5.8, "Niger": 7.07, "Nigeria": 6.5, "North Macedonia": 4.16, "Norway": 3.38, "Oman": 4.02, "Pakistan": 6.65, "Panama": 4.56, "Papua New Guinea": 5.34, "Paraguay": 4.72, "Peru": 5.28, "Philippines": 5.8, "Poland": 4.15, "Portugal": 3.43, "Qatar": 3.2, "Romania": 4.05, "Russia": 5.96, "Rwanda": 5.47, "Saudi Arabia": 4.42, "Senegal": 5.4, "Serbia": 5.04, "Sierra Leone": 5.64, "Singapore": 3.04, "Slovakia": 3.79, "Slovenia": 3.48, "South Africa": 5.22, "South Korea": 3.57, "Spain": 3.7, "Sri Lanka": 5.11, "Sudan": 7.1, "Sweden": 3.52, "Switzerland": 2.78, "Syrian Arab Republic": 7.33, "Tajikistan": 5.69, "Thailand": 5.21, "Timor-Leste": 5.15, "Togo": 5.87, "Trinidad and Tobago": 4.38, "Tunisia": 5.13, "Turkey": 5.26, "Uganda": 6.29, "Ukraine": 6.35, "United Arab Emirates": 3.72, "United Kingdom": 3.32, "United States": 4.19, "Uruguay": 3.91, "Venezuela": 5.77, "Vietnam": 4.32, "Yemen": 6.3, "Zambia": 4.95, "Zimbabwe": 6.14}, "sectors": {"Aerospace and defense": 1.0, "Agribusiness, commodity foods, and agricultural cooperatives": 1.0, "Asset managers": 1.0, "Auto and commercial vehicle manufacturing": 1.1, "Auto suppliers": 1.1, "Building materials": 1.0, "Business and consumer services": 1.0, "Capital goods": 1.0, "Charter schools": 1.1, "Commodity chemicals": 1.1, "Consumer durables": 1.0, "Consumer staples and branded nondurables": 0.85, "Containers and packaging": 1.0, "Digital infrastructure": 0.85, "Engineering and construction": 1.1, "Environmental services": 0.85, "Financial market infrastructure companies": 0.85, "Financial services finance companies": 1.1, "Forest and paper products": 1.1, "Health care equipment": 0.85, "Health care services": 1.0, "Homebuilders and real estate developers": 1.1, "Leisure and sports": 1.0, "Long-term municipal pools": 0.85, "Media and entertainment": 1.0, "Metals production and processing": 1.1, "Midstream energy": 1.0, "Mining": 1.1, "Municipal retail electric and gas utilities": 0.75, "Municipal water and waste - Irrigation": 0.75, "Municipal water and waste - Solid waste": 0.85, "Municipal water and waste - Water, sewer, and combined": 0.75, "Not-for-profit acute care health care organizations": 1.0, "Not-for-profit education providers": 0.85, "Not-for-profit transportation infrastructure enterprises - Airports and ports": 0.85, "Not-for-profit transportation infrastructure enterprises - Toll roads, parking systems, and mass transit": 0.85, "Oil and gas exploration and production": 1.1, "Oilfield services and equipment": 1.1, "Pharmaceuticals": 0.85, "Public and nonprofit social housing providers": 0.85, "Railroads, package express, and logistics": 0.85, "Real estate": 0.85, "Refining and marketing": 1.1, "Regulated utilities": 0.75, "Retail and restaurants": 1.0, "Specialty chemicals": 0.85, "Technology hardware and semiconductors": 1.1, "Technology software and services": 1.0, "Telecommunications": 1.0, "Transportation cyclical": 1.15, "Transportation infrastructure": 0.85, "Transportation leasing": 1.0, "Unregulated power and gas": 1.1, "Insurance (Financial services)": 1.1}, "benchmark": [{"company": "Allianz", "hq_risk": 3.42, "revenue": 3.3948, "supply_chain": 3.6316, "fin_mult": 0.9, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.2342, "sector": "Insurance (Financial services)"}, {"company": "Amazon", "hq_risk": 4.19, "revenue": 6.0438, "supply_chain": 4.1107, "fin_mult": 0.9, "sec_mult": 1.0, "vol_mult": 0.9348, "cgri": 4.1224, "sector": "Retail and restaurants"}, {"company": "Apple", "hq_risk": 4.19, "revenue": 4.1049, "supply_chain": 3.9888, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.3527, "sector": "Technology hardware and semiconductors"}, {"company": "ASML", "hq_risk": 3.59, "revenue": 4.4116, "supply_chain": 3.9345, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.3370, "sector": "Technology hardware and semiconductors"}, {"company": "BNP Paribas", "hq_risk": 3.65, "revenue": 3.3561, "supply_chain": 3.5689, "fin_mult": 1.1, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.9590, "sector": "Financial services finance companies"}, {"company": "Eli Lilly", "hq_risk": 4.19, "revenue": 4.1002, "supply_chain": 4.3947, "fin_mult": 1.0, "sec_mult": 0.85, "vol_mult": 0.9348, "cgri": 3.3659, "sector": "Pharmaceuticals"}, {"company": "ENI", "hq_risk": 3.84, "revenue": 3.9368, "supply_chain": 3.6252, "fin_mult": 0.9, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.5102, "sector": "Oil and gas exploration and production"}, {"company": "Ford", "hq_risk": 4.19, "revenue": 5.0981, "supply_chain": 3.6667, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.5735, "sector": "Auto and commercial vehicle manufacturing"}, {"company": "JP Morgan", "hq_risk": 4.19, "revenue": 5.0411, "supply_chain": 4.1176, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.7031, "sector": "Financial services finance companies"}, {"company": "L'Oreal", "hq_risk": 3.65, "revenue": 4.0243, "supply_chain": 3.5945, "fin_mult": 0.9, "sec_mult": 0.85, "vol_mult": 0.9348, "cgri": 2.7015, "sector": "Consumer staples and branded nondurables"}, {"company": "LVMH", "hq_risk": 3.65, "revenue": 4.061, "supply_chain": 3.5303, "fin_mult": 0.9, "sec_mult": 1.0, "vol_mult": 0.9348, "cgri": 3.1689, "sector": "Consumer durables"}, {"company": "Meta", "hq_risk": 4.19, "revenue": 4.0756, "supply_chain": 3.6147, "fin_mult": 0.8, "sec_mult": 1.0, "vol_mult": 0.9348, "cgri": 2.9272, "sector": "Technology software and services"}, {"company": "Microsoft", "hq_risk": 4.19, "revenue": 5.2125, "supply_chain": 4.0612, "fin_mult": 0.9, "sec_mult": 1.0, "vol_mult": 0.9348, "cgri": 3.8260, "sector": "Technology software and services"}, {"company": "Novo Nordisk", "hq_risk": 3.2, "revenue": 5.1711, "supply_chain": 3.5089, "fin_mult": 0.9, "sec_mult": 0.85, "vol_mult": 0.9348, "cgri": 2.9407, "sector": "Pharmaceuticals"}, {"company": "NVIDIA", "hq_risk": 4.19, "revenue": 5.2612, "supply_chain": 4.0712, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.7603, "sector": "Technology hardware and semiconductors"}, {"company": "Procter & Gamble", "hq_risk": 4.19, "revenue": 4.5829, "supply_chain": 4.1289, "fin_mult": 0.9, "sec_mult": 0.85, "vol_mult": 0.9348, "cgri": 3.0914, "sector": "Consumer staples and branded nondurables"}, {"company": "Reliance Industries", "hq_risk": 5.07, "revenue": 7.3623, "supply_chain": 5.069, "fin_mult": 0.9, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 5.5404, "sector": "Oil and gas exploration and production"}, {"company": "Samsung", "hq_risk": 3.57, "revenue": 4.0305, "supply_chain": 3.9529, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.2144, "sector": "Technology hardware and semiconductors"}, {"company": "SAP", "hq_risk": 4.19, "revenue": 4.366, "supply_chain": 3.9279, "fin_mult": 0.8, "sec_mult": 1.0, "vol_mult": 0.9348, "cgri": 3.1078, "sector": "Technology software and services"}, {"company": "Sony", "hq_risk": 3.38, "revenue": 3.9319, "supply_chain": 3.9435, "fin_mult": 0.9, "sec_mult": 1.0, "vol_mult": 0.9348, "cgri": 3.2191, "sector": "Consumer durables"}, {"company": "Tencent", "hq_risk": 4.26, "revenue": 6.3838, "supply_chain": 5.1913, "fin_mult": 0.9, "sec_mult": 1.0, "vol_mult": 0.9348, "cgri": 4.6123, "sector": "Technology software and services"}, {"company": "Total Energies", "hq_risk": 3.65, "revenue": 3.4741, "supply_chain": 3.6285, "fin_mult": 0.9, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.3049, "sector": "Oil and gas exploration and production"}, {"company": "Toyota", "hq_risk": 3.38, "revenue": 4.013, "supply_chain": 3.607, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 3.0635, "sector": "Auto and commercial vehicle manufacturing"}, {"company": "TSMC", "hq_risk": 4.26, "revenue": 6.2517, "supply_chain": 3.9383, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 4.0540, "sector": "Technology hardware and semiconductors"}, {"company": "Volkswagen", "hq_risk": 3.42, "revenue": 3.4274, "supply_chain": 3.6886, "fin_mult": 0.8, "sec_mult": 1.1, "vol_mult": 0.9348, "cgri": 2.9043, "sector": "Auto and commercial vehicle manufacturing"}], "vol_mult": 0.934828};

// ═══════════════════════════════════════════════════════════════════════════
// HELPERS
// ═══════════════════════════════════════════════════════════════════════════
function riskLabel(s){
  if(s<3.5)return'Low';if(s<5)return'Moderate';if(s<6.5)return'High';return'Very High';
}
const RISK_COLORS={Low:'#27ae60',Moderate:'#f39c12',High:'#e67e22','Very High':'#e74c3c'};
const PALETTE=['#E8601A','#2980b9','#27ae60','#8e44ad','#e74c3c','#16a085','#f39c12','#2c3e50','#d35400','#1abc9c','#c0392b','#7f8c8d','#3498db','#e91e63','#009688','#ff5722','#673ab7','#4caf50','#ff9800','#795548','#607d8b','#f06292','#00bcd4','#8bc34a','#9c27b0','#b71c1c','#0d47a1','#1b5e20','#4a148c','#e65100','#006064','#f57f17','#37474f','#880e4f','#33691e','#01579b','#bf360c','#004d40','#827717','#212121','#6a1b9a','#0277bd','#558b2f','#ff6f00','#ad1457','#00838f','#c62828','#283593','#2e7d32','#6a1b9a'];

function normalizeWeights(obj){
  const total=Object.values(obj).reduce((a,b)=>a+b,0);
  if(total<=0)return{};
  const out={};Object.entries(obj).forEach(([k,v])=>out[k]=v/total);return out;
}
function weightedGRI(shares){
  return Object.entries(shares).reduce((s,[c,w])=>s+(DATA.countries[c]||0)*w,0);
}
function hhi(shares){return Object.values(shares).reduce((s,w)=>s+w*w,0);}
function hhiSub(h){
  if(h<0.15)return 0.90;if(h<0.25)return 1.00;if(h<0.40)return 1.10;if(h<0.60)return 1.25;return 1.50;
}
function finMult(x){
  if(x<0)return 0.8;if(x<2)return 0.9;if(x<4)return 1.0;if(x<6)return 1.1;return 1.2;
}

// ═══════════════════════════════════════════════════════════════════════════
// TAB NAVIGATION
// ═══════════════════════════════════════════════════════════════════════════
function showTab(id){
  document.querySelectorAll('.cgri-page').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.cgri-tab').forEach(t=>t.classList.remove('active'));
  document.getElementById('tab-'+id).classList.add('active');
  const idx={dashboard:0,calculator:1,methodology:2}[id];
  document.querySelectorAll('.cgri-tab')[idx].classList.add('active');
}

// ═══════════════════════════════════════════════════════════════════════════
// DASHBOARD
// ═══════════════════════════════════════════════════════════════════════════
let barChart, radarChart, stackChart;
let sortCol='cgri', sortDir='desc';
let filteredData=[...DATA.benchmark];

function riskColor(s){return RISK_COLORS[riskLabel(s)];}

function buildKPIs(){
  const scores=DATA.benchmark.map(d=>d.cgri);
  const avg=(scores.reduce((a,b)=>a+b,0)/scores.length).toFixed(2);
  const maxB=DATA.benchmark.reduce((a,b)=>b.cgri>a.cgri?b:a);
  const minB=DATA.benchmark.reduce((a,b)=>b.cgri<a.cgri?b:a);
  const nHigh=DATA.benchmark.filter(d=>riskLabel(d.cgri)==='High'||riskLabel(d.cgri)==='Very High').length;
  document.getElementById('kpi-row').innerHTML=
    '<div class="kpi-card"><div class="kpi-label">Portfolio Average</div><div class="kpi-value">'+avg+'</div><div class="kpi-sub">mean CGRI score</div></div>'+
    '<div class="kpi-card" style="border-left-color:#e74c3c"><div class="kpi-label">Highest Risk</div><div class="kpi-value">'+maxB.cgri.toFixed(2)+'</div><div class="kpi-sub">'+maxB.company+'</div></div>'+
    '<div class="kpi-card" style="border-left-color:#27ae60"><div class="kpi-label">Lowest Risk</div><div class="kpi-value">'+minB.cgri.toFixed(2)+'</div><div class="kpi-sub">'+minB.company+'</div></div>'+
    '<div class="kpi-card" style="border-left-color:#e67e22"><div class="kpi-label">High / Very High</div><div class="kpi-value">'+nHigh+'</div><div class="kpi-sub">of '+DATA.benchmark.length+' companies</div></div>';
}

function buildSectorFilter(){
  const sectors=[...new Set(DATA.benchmark.map(d=>d.sector))].sort();
  const sel=document.getElementById('f-sector');
  sel.innerHTML='<option value="">All sectors</option>'+sectors.map(s=>'<option>'+s+'</option>').join('');
}

function applyFilters(){
  const risk=document.getElementById('f-risk').value;
  const sector=document.getElementById('f-sector').value;
  const sortDir=document.getElementById('f-sort').value;
  filteredData=DATA.benchmark.filter(d=>{
    if(risk&&riskLabel(d.cgri)!==risk)return false;
    if(sector&&d.sector!==sector)return false;
    return true;
  }).sort((a,b)=>sortDir==='asc'?a.cgri-b.cgri:b.cgri-a.cgri);
  renderDashboard();
}

function sortTable(col){
  if(sortCol===col)sortDir=sortDir==='asc'?'desc':'asc';
  else{sortCol=col;sortDir='desc';}
  filteredData.sort((a,b)=>{
    const va=a[col],vb=b[col];
    if(typeof va==='string')return sortDir==='asc'?va.localeCompare(vb):vb.localeCompare(va);
    return sortDir==='asc'?va-vb:vb-va;
  });
  renderDashboard();
}

function renderDashboard(){
  // Bar chart
  const labels=filteredData.map(d=>d.company);
  const values=filteredData.map(d=>d.cgri);
  const colors=filteredData.map(d=>riskColor(d.cgri));
  if(barChart)barChart.destroy();
  barChart=new Chart(document.getElementById('barChart'),{
    type:'bar',
    data:{labels,datasets:[{data:values,backgroundColor:colors,borderRadius:4}]},
    options:{responsive:true,plugins:{legend:{display:false},tooltip:{callbacks:{label:function(ctx){return 'CGRI: '+ctx.parsed.y.toFixed(2)+' \u2014 '+riskLabel(ctx.parsed.y);}}}},scales:{x:{ticks:{maxRotation:90,font:{size:10}}},y:{beginAtZero:false,min:2,title:{display:true,text:'CGRI Score'}}}}
  });

  // Stacked chart
  const wHQ=filteredData.map(d=>(0.20*d.hq_risk).toFixed(3));
  const wRev=filteredData.map(d=>(0.40*d.revenue).toFixed(3));
  const wSC=filteredData.map(d=>(0.40*d.supply_chain).toFixed(3));
  if(stackChart)stackChart.destroy();
  stackChart=new Chart(document.getElementById('stackChart'),{
    type:'bar',
    data:{labels,datasets:[
      {label:'HQ Risk (w)',data:wHQ,backgroundColor:'#4b6fff',borderRadius:0},
      {label:'Revenue (w)',data:wRev,backgroundColor:'#00c897',borderRadius:0},
      {label:'Supply Chain (w)',data:wSC,backgroundColor:'#f05545',borderRadius:0},
    ]},
    options:{responsive:true,plugins:{legend:{position:'bottom',labels:{font:{size:11}}}},scales:{x:{stacked:true,ticks:{maxRotation:90,font:{size:10}}},y:{stacked:true,title:{display:true,text:'Weighted Score'}}}}
  });

  // Radar select
  const rsel=document.getElementById('radar-select');
  const prevSelected=[...rsel.selectedOptions].map(o=>o.value);
  rsel.innerHTML=filteredData.map(d=>'<option value="'+d.company+'" '+(prevSelected.includes(d.company)||prevSelected.length===0?'selected':'')+'>'+d.company+'</option>').join('');
  // default: first 3
  if(prevSelected.length===0)[...rsel.options].forEach((o,i)=>o.selected=i<3);
  updateRadar();

  // Table
  const tbody=document.getElementById('bench-tbody');
  tbody.innerHTML=filteredData.map(d=>{
    const rl=riskLabel(d.cgri);
    return '<tr>'+
      '<td><b>'+d.company+'</b></td>'+
      '<td style="max-width:160px;white-space:normal;font-size:0.78rem">'+d.sector+'</td>'+
      '<td><b>'+d.cgri.toFixed(2)+'</b></td>'+
      '<td><span class="risk-badge risk-'+rl.replace(' ','.')+'">'+rl+'</span></td>'+
      '<td>'+d.hq_risk.toFixed(2)+'</td>'+
      '<td>'+d.revenue.toFixed(2)+'</td>'+
      '<td>'+d.supply_chain.toFixed(2)+'</td>'+
      '<td>\xd7'+d.fin_mult.toFixed(1)+'</td>'+
      '<td>\xd7'+d.sec_mult.toFixed(2)+'</td>'+
      '</tr>';
  }).join('');
}

function updateRadar(){
  const selected=[...document.getElementById('radar-select').selectedOptions].map(o=>o.value);
  const rows=filteredData.filter(d=>selected.includes(d.company));
  const expanded=document.getElementById('radar-expanded').checked;
  let dims,datasets;
  if(expanded){
    dims=['HQ Risk','Revenue Exposure','Supply Chain','Fin. Leverage','Sector Risk'];
    datasets=rows.map((d,i)=>({
      label:d.company,
      data:[
        d.hq_risk,
        d.revenue,
        d.supply_chain,
        (d.fin_mult-0.8)/(1.2-0.8)*10,
        (d.sec_mult-0.75)/(1.25-0.75)*10,
      ],
      borderColor:PALETTE[i%PALETTE.length],
      backgroundColor:PALETTE[i%PALETTE.length]+'33',
      borderWidth:2,pointRadius:3,
    }));
  } else {
    dims=['HQ Risk','Revenue Exposure','Supply Chain'];
    datasets=rows.map((d,i)=>({
      label:d.company,
      data:[d.hq_risk,d.revenue,d.supply_chain],
      borderColor:PALETTE[i%PALETTE.length],
      backgroundColor:PALETTE[i%PALETTE.length]+'33',
      borderWidth:2,pointRadius:3,
    }));
  }
  if(radarChart)radarChart.destroy();
  radarChart=new Chart(document.getElementById('radarChart'),{
    type:'radar',
    data:{labels:dims,datasets},
    options:{responsive:true,scales:{r:{min:0,max:10,ticks:{stepSize:2,font:{size:9}},pointLabels:{font:{size:11}}}},plugins:{legend:{position:'bottom',labels:{font:{size:10},boxWidth:12}}}}
  });
}

// ═══════════════════════════════════════════════════════════════════════════
// CALCULATOR — row management
// ═══════════════════════════════════════════════════════════════════════════
const countryOpts=Object.keys(DATA.countries).sort().map(c=>'<option value="'+c+'">'+c+'</option>').join('');

function addRow(key, country='', weight=0){
  const container=document.getElementById(key+'-rows');
  const id=Date.now()+Math.random();
  const div=document.createElement('div');
  div.className='exp-row';
  div.dataset.id=id;
  div.innerHTML=
    '<select onchange="updateShares(\''+key+'\')"><option value="">\u2014 select country \u2014</option>'+countryOpts+'</select>'+
    '<input type="number" min="0" step="1" value="'+weight+'" oninput="updateShares(\''+key+'\')"/>'+
    '<span class="share-pill empty">\u2014</span>'+
    '<span class="gri-tag">\u2014</span>'+
    '<button class="btn-del-row" onclick="delRow(\''+key+'\',\''+id+'\')">&#x2715;</button>';
  if(country){div.querySelector('select').value=country;}
  container.appendChild(div);
  updateShares(key);
}

function delRow(key, id){
  const container=document.getElementById(key+'-rows');
  const row=container.querySelector('[data-id="'+id+'"]');
  if(row)container.removeChild(row);
  updateShares(key);
}

function updateShares(key){
  const rows=[...document.getElementById(key+'-rows').querySelectorAll('.exp-row')];
  const vals=rows.map(r=>({c:r.querySelector('select').value,w:parseFloat(r.querySelector('input').value)||0})).filter(r=>r.c&&r.w>0);
  const total=vals.reduce((s,r)=>s+r.w,0);
  rows.forEach(r=>{
    const c=r.querySelector('select').value, w=parseFloat(r.querySelector('input').value)||0;
    const pill=r.querySelector('.share-pill');
    const gri=r.querySelector('.gri-tag');
    if(c&&w>0&&total>0){
      pill.textContent=(w/total*100).toFixed(1)+'%';
      pill.classList.remove('empty');
      gri.textContent=DATA.countries[c]?DATA.countries[c].toFixed(2):'—';
    } else {
      pill.textContent='—';
      pill.classList.add('empty');
      gri.textContent='—';
    }
  });
}

function getExposure(key){
  const rows=[...document.getElementById(key+'-rows').querySelectorAll('.exp-row')];
  const out={};
  rows.forEach(r=>{
    const c=r.querySelector('select').value, w=parseFloat(r.querySelector('input').value)||0;
    if(c&&w>0)out[c]=(out[c]||0)+w;
  });
  return out;
}

// leverage hint
document.addEventListener('DOMContentLoaded',()=>{
  document.getElementById('c-leverage').addEventListener('input',function(){
    const m=finMult(parseFloat(this.value)||0);
    document.getElementById('lev-hint').textContent='Financial multiplier: \xd7'+m.toFixed(1);
  });
});

// ═══════════════════════════════════════════════════════════════════════════
// CALCULATOR — compute
// ═══════════════════════════════════════════════════════════════════════════
let calcRadarChart, calcBarChart;

function computeCGRI(){
  const alertBox=document.getElementById('calc-alert');
  alertBox.innerHTML='';

  const name=document.getElementById('c-name').value.trim()||'My Company';
  const hqC=document.getElementById('c-country').value;
  const sector=document.getElementById('c-sector').value;
  const leverage=parseFloat(document.getElementById('c-leverage').value)||0;

  const revRaw=getExposure('rev');
  const supRaw=getExposure('sup');
  const supfacRaw=getExposure('supfac');

  const missing=[];
  if(!hqC)missing.push('HQ Country');
  if(!Object.keys(revRaw).length)missing.push('Revenue by Country');
  if(!Object.keys(supRaw).length)missing.push('Supplier Distribution');
  if(!Object.keys(supfacRaw).length)missing.push('Supplier Facility Distribution');
  if(missing.length){alertBox.innerHTML='<div class="alert alert-warn">Please fill in: <b>'+missing.join(', ')+'</b></div>';return;}

  // Compute
  const hqRisk=DATA.countries[hqC];
  const revShares=normalizeWeights(revRaw);
  const supShares=normalizeWeights(supRaw);
  const supfacShares=normalizeWeights(supfacRaw);

  const revComp=weightedGRI(revShares)*hhiSub(hhi(revShares));
  const supComp=weightedGRI(supShares);
  const facComp=weightedGRI(supfacShares);
  const scIntermediate=0.5*supComp+0.5*facComp;
  const hhiCombined=(hhi(supShares)+hhi(supfacShares))/2;
  const scComp=scIntermediate*hhiSub(hhiCombined);

  const fm=finMult(leverage);
  const sm=DATA.sectors[sector]||1.0;
  const vm=DATA.vol_mult;

  const base=0.20*hqRisk+0.40*revComp+0.40*scComp;
  const cgri=base*sm*vm*fm;
  const rl=riskLabel(cgri);

  // Score card
  document.getElementById('score-box').innerHTML=
    '<div class="score-card '+rl.replace(' ','-')+'">'+
      '<div class="score-co">'+name+'</div>'+
      '<div class="score-num">'+cgri.toFixed(2)+'</div>'+
      '<div class="score-cat">'+rl+' Risk</div>'+
    '</div>';

  // Component cards
  document.getElementById('comp-cards').innerHTML=
    '<div class="comp-card"><div class="cl">HQ Risk</div><div class="cv">'+hqRisk.toFixed(2)+'</div><div class="cd">'+hqC+'</div></div>'+
    '<div class="comp-card"><div class="cl">Revenue Exposure</div><div class="cv">'+revComp.toFixed(2)+'</div><div class="cd">HHI sub \xd7'+hhiSub(hhi(revShares)).toFixed(2)+'</div></div>'+
    '<div class="comp-card"><div class="cl">Supply Chain</div><div class="cv">'+scComp.toFixed(2)+'</div><div class="cd">HHI sub \xd7'+hhiSub(hhiCombined).toFixed(2)+'</div></div>'+
    '<div class="comp-card"><div class="cl">Financial Leverage</div><div class="cv">\xd7'+fm.toFixed(1)+'</div><div class="cd">Net D/EBITDA '+leverage.toFixed(2)+'</div></div>'+
    '<div class="comp-card"><div class="cl">Sector Multiplier</div><div class="cv">\xd7'+sm.toFixed(2)+'</div><div class="cd">'+sector+'</div></div>'+
    '<div class="comp-card"><div class="cl">Volatility Multiplier</div><div class="cv">\xd7'+vm.toFixed(4)+'</div><div class="cd">2024 VIX avg</div></div>';

  // Radar vs benchmark avg
  const bAvgHQ=DATA.benchmark.reduce((s,d)=>s+d.hq_risk,0)/DATA.benchmark.length;
  const bAvgRev=DATA.benchmark.reduce((s,d)=>s+d.revenue,0)/DATA.benchmark.length;
  const bAvgSC=DATA.benchmark.reduce((s,d)=>s+d.supply_chain,0)/DATA.benchmark.length;
  if(calcRadarChart)calcRadarChart.destroy();
  calcRadarChart=new Chart(document.getElementById('calcRadar'),{
    type:'radar',
    data:{
      labels:['HQ Risk','Revenue Exposure','Supply Chain'],
      datasets:[
        {label:name,data:[hqRisk,revComp,scComp],borderColor:'#E8601A',backgroundColor:'#E8601A33',borderWidth:2.5,pointRadius:4},
        {label:'Benchmark avg',data:[bAvgHQ,bAvgRev,bAvgSC],borderColor:'#2980b9',backgroundColor:'#2980b933',borderWidth:2,pointRadius:3},
      ]
    },
    options:{responsive:true,scales:{r:{min:0,max:10,ticks:{stepSize:2,font:{size:9}},pointLabels:{font:{size:11}}}},plugins:{legend:{position:'bottom',labels:{font:{size:11},boxWidth:12}}}}
  });

  // Ranking bar
  const allWithCustom=[...DATA.benchmark.map(d=>({company:d.company,cgri:d.cgri,custom:false})),{company:'\u25b6 '+name,cgri:cgri,custom:true}]
    .sort((a,b)=>b.cgri-a.cgri);
  if(calcBarChart)calcBarChart.destroy();
  calcBarChart=new Chart(document.getElementById('calcBar'),{
    type:'bar',
    data:{
      labels:allWithCustom.map(d=>d.company),
      datasets:[{data:allWithCustom.map(d=>d.cgri),backgroundColor:allWithCustom.map(d=>d.custom?'#1a1a1a':riskColor(d.cgri)),borderRadius:3}]
    },
    options:{responsive:true,plugins:{legend:{display:false},tooltip:{callbacks:{label:function(ctx){return 'CGRI: '+ctx.parsed.y.toFixed(2);}}}},scales:{x:{ticks:{maxRotation:90,font:{size:9}}},y:{beginAtZero:false,min:2,title:{display:true,text:'CGRI Score'}}}}
  });

  document.getElementById('calc-results').style.display='block';
  document.getElementById('calc-results').scrollIntoView({behavior:'smooth',block:'start'});
}

// ═══════════════════════════════════════════════════════════════════════════
// INIT — dynamically load Chart.js then boot (works inside Elementor)
// ═══════════════════════════════════════════════════════════════════════════
function _cgriInit(){
  // Populate country dropdown
  const cSel=document.getElementById('c-country');
  cSel.innerHTML='<option value="">— select —</option>'+countryOpts;

  // Populate sector dropdown
  const sSel=document.getElementById('c-sector');
  sSel.innerHTML=Object.keys(DATA.sectors).sort().map(s=>'<option value="'+s+'">'+s+'</option>').join('');

  // Default exposure rows
  addRow('rev');addRow('sup');addRow('supfac');

  // Dashboard
  buildKPIs();
  buildSectorFilter();
  filteredData=[...DATA.benchmark].sort((a,b)=>b.cgri-a.cgri);
  renderDashboard();
}

(function(){
  if(typeof Chart!=='undefined'){
    _cgriInit();
  } else {
    const s=document.createElement('script');
    s.src='https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js';
    s.onload=_cgriInit;
    document.head.appendChild(s);
  }
})();
</script>
</body>
</html>

CGRI_END;
