<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?= esc($title ?? 'Admin Panel | Rupanjali') ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Georgia', 'serif'],
                    },
                    colors: {
                        rosebrand: '#c65d72',
                        ink: '#292322',
                        cream: '#faf6f3',
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #faf6f3;
            color: #292322;
        }

        .admin-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .admin-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-scrollbar::-webkit-scrollbar-thumb {
            background: #e5c5cc;
            border-radius: 999px;
        }

        @media (max-width: 767px) {
            input,
            textarea,
            select,
            button {
                font-size: 16px !important;
            }
        }

        /* Shared admin content components */
        .admin-main {
            min-height: 100vh;
            padding: 40px;
            margin-left: 270px;
            background: #faf6f3;
        }

        .admin-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .admin-page-header h1 {
            margin: 4px 0 8px;
            font-family: Georgia, serif;
            font-size: 34px;
            font-weight: 600;
            color: #292322;
        }

        .admin-eyebrow {
            margin: 0;
            color: #a65b6b;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .admin-muted {
            margin: 0;
            color: #766b68;
            font-size: 14px;
        }

        .admin-card {
            overflow: hidden;
            border: 1px solid #eadfda;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 8px 30px rgba(70, 45, 35, 0.04);
        }

        .admin-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px 26px;
            border-bottom: 1px solid #eee5e1;
        }

        .admin-card-header h2 {
            margin: 0 0 5px;
            font-family: Georgia, serif;
            font-size: 22px;
            font-weight: 600;
            color: #292322;
        }

        .admin-filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .admin-input {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            border: 1px solid #ded3ce;
            border-radius: 10px;
            background: #ffffff;
            color: #292322;
            font: inherit;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .admin-input:focus {
            border-color: #c65d72;
            box-shadow: 0 0 0 3px rgba(198, 93, 114, 0.12);
        }

        .admin-filter-bar .admin-input {
            width: auto;
            min-width: 220px;
        }

        .admin-filter-bar select.admin-input {
            min-width: 150px;
        }

        .admin-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 10px 18px;
            border: 1px solid #c65d72;
            border-radius: 10px;
            background: #c65d72;
            color: #ffffff !important;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none !important;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .admin-button:hover {
            background: #ad4c61;
            transform: translateY(-1px);
        }

        .admin-button-light {
            border-color: #ded3ce;
            background: #ffffff;
            color: #594d49 !important;
        }

        .admin-button-light:hover {
            background: #f8f1ee;
        }

        .admin-button-secondary {
            border-color: #8e6b72;
            background: #8e6b72;
        }

        .admin-alert {
            margin-bottom: 22px;
            padding: 14px 17px;
            border-radius: 10px;
            font-size: 14px;
        }

        .admin-alert-success {
            border: 1px solid #b9dfc5;
            background: #edf9f0;
            color: #246b38;
        }

        .admin-alert-error {
            border: 1px solid #efc3c3;
            background: #fff0f0;
            color: #a33a3a;
        }

        .admin-alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .admin-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .admin-table {
            width: 100%;
            min-width: 850px;
            border-collapse: collapse;
        }

        .admin-table th {
            padding: 15px 18px;
            border-bottom: 1px solid #e9dfdb;
            background: #fcf8f6;
            color: #766b68;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .admin-table td {
            padding: 18px;
            border-bottom: 1px solid #f0e8e4;
            color: #403633;
            font-size: 14px;
            vertical-align: top;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .admin-table tbody tr:hover {
            background: #fffaf8;
        }

        .admin-mini-list {
            margin: 8px 0 0;
            padding-left: 18px;
            color: #766b68;
            font-size: 13px;
            line-height: 1.7;
        }

        .admin-status {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .admin-status-active {
            background: #e9f7ed;
            color: #27733d;
        }

        .admin-status-inactive {
            background: #f3e9e7;
            color: #8a6b64;
        }

        .admin-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            white-space: nowrap;
        }

        .admin-action-link {
            color: #a64e62;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .admin-action-link:hover {
            text-decoration: underline;
        }

        .admin-action-danger {
            color: #b24c4c;
        }

        .admin-empty-state {
            padding: 55px 24px;
            text-align: center;
        }

        .admin-empty-state h3 {
            margin: 0 0 8px;
            font-family: Georgia, serif;
            font-size: 22px;
        }

        .admin-empty-state p {
            margin: 0 0 20px;
            color: #766b68;
        }

        .admin-form {
            padding: 28px;
        }

        .admin-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .admin-form-group {
            display: flex;
            min-width: 0;
            flex-direction: column;
            gap: 8px;
        }

        .admin-form-group-full {
            grid-column: 1 / -1;
        }

        .admin-form-group label {
            color: #493d39;
            font-size: 14px;
            font-weight: 700;
        }

        .admin-help-text {
            color: #8b7c76;
            font-size: 12px;
            font-weight: 400;
        }

        .admin-form-group textarea.admin-input {
            resize: vertical;
            line-height: 1.6;
        }

        .admin-form-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #eee5e1;
        }

        @media (max-width: 900px) {
            .admin-main {
                margin-left: 0;
                padding: 28px 22px;
            }
        }

        @media (max-width: 640px) {
            .admin-main {
                padding: 24px 16px;
            }

            .admin-page-header {
                flex-direction: column;
            }

            .admin-page-header h1 {
                font-size: 29px;
            }

            .admin-filter-bar {
                align-items: stretch;
                flex-direction: column;
            }

            .admin-filter-bar .admin-input,
            .admin-filter-bar select.admin-input {
                width: 100%;
                min-width: 0;
            }

            .admin-filter-bar .admin-button {
                width: 100%;
            }

            .admin-form {
                padding: 20px;
            }

            .admin-form-grid {
                grid-template-columns: 1fr;
            }

            .admin-form-group-full {
                grid-column: auto;
            }

            .admin-form-actions {
                justify-content: stretch;
            }

            .admin-form-actions .admin-button {
                flex: 1;
            }
        }

    </style>
</head>

<body class="min-h-screen bg-[#faf6f3]">