<template>

    <Head title="Mentions Légales - JaaJ FM" />

    <div class="min-h-screen bg-gradient-to-br from-purple-600 via-orange-500 to-cyan-500">
        <!-- Formes décoratives en arrière-plan -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute w-48 h-48 bg-cyan-400 rounded-full top-10 right-10 opacity-10 animate-float"></div>
            <div
                class="absolute w-36 h-36 bg-orange-500 transform rotate-45 bottom-20 left-15 opacity-10 animate-float-reverse">
            </div>
            <div class="absolute w-24 h-24 bg-purple-600 rounded-full top-1/2 right-30 opacity-10 animate-float"></div>
        </div>

        <!-- Version Desktop -->
        <div class="hidden md:flex min-h-screen">
            <!-- Sidebar -->
            <Sidebar />

            <!-- Contenu principal -->
            <main class="flex-1 ml-64 p-5 relative">
                <!-- Header -->
                <Header @live-radio-toggle="handleLiveRadioToggle" />

                <!-- Contenu -->
                <div class="space-y-8">
                    <!-- Section Mentions Légales -->
                    <section class="glass rounded-2xl p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <button @click="goBack" class="text-white hover:text-purple-300 transition-colors">
                                <ArrowLeftIcon class="w-6 h-6" />
                            </button>
                            <h1 class="text-3xl font-bold text-white">Mentions Légales</h1>
                        </div>

                        <div class="prose prose-invert max-w-none">
                            <div class="text-white space-y-6">
                                <!-- Éditeur du site -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Éditeur du site</h2>
                                    <div class="text-white/90 leading-relaxed space-y-2">
                                        <p><strong>Statut :</strong> Particulier - Site personnel non-commercial</p>
                                        <p><strong>Nom :</strong> Cyril Mignon</p>
                                        <p><strong>Localisation :</strong> Ottignies, Belgique</p>
                                        <p><strong>Contact :</strong> contact@jaajfm.com</p>
                                        <p><strong>Site web :</strong> www.jaajfm.com</p>
                                        <p class="text-sm text-white/70">Note : Les données complètes d'identification
                                            de l'éditeur ont été transmises à l'hébergeur conformément à la
                                            réglementation belge.</p>
                                    </div>
                                </div>

                                <!-- Hébergeur du site -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Hébergeur du site</h2>
                                    <div class="text-white/90 leading-relaxed space-y-2">
                                        <p><strong>Nom de l'hébergeur :</strong> o2switch</p>
                                        <p><strong>Adresse :</strong> 222-224 Boulevard Gustave Flaubert, 63000
                                            Clermont-Ferrand, France</p>
                                        <p><strong>Téléphone :</strong> 04 44 44 60 40</p>
                                        <p><strong>Site web :</strong> www.o2switch.fr</p>
                                        <p class="text-sm text-white/70">Note : Conformément à la législation, les
                                            données complètes d'identification de l'éditeur ont été transmises à
                                            l'hébergeur.</p>
                                    </div>
                                </div>

                                <!-- Objet du site -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Objet du site</h2>
                                    <p class="text-white/90 leading-relaxed mb-3">JaaJ FM est une plateforme de réseau
                                        social musical permettant aux utilisateurs de :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4">
                                        <li>Partager des créations musicales (générées par IA ou traditionnelles)</li>
                                        <li>Découvrir de nouvelles musiques</li>
                                        <li>Participer à des classements communautaires</li>
                                        <li>Écouter une radio en direct</li>
                                        <li>Interagir avec une communauté de créateurs musicaux</li>
                                    </ul>
                                </div>

                                <!-- Propriété intellectuelle -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Propriété intellectuelle et
                                        droits d'auteur</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Contenu du site JaaJ FM</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Le site JaaJ FM constitue une création
                                        protégée par le droit d'auteur. Tous les éléments du site JaaJ FM (design,
                                        structure, logos, textes, images, sons, vidéos, interface, etc.) sont la
                                        propriété exclusive de Cyril Mignon ou font l'objet de licences d'utilisation,
                                        sauf mention contraire.</p>
                                    <p class="text-white/90 leading-relaxed mb-4">Toute reproduction, représentation,
                                        modification, publication, adaptation, transmission ou diffusion, totale ou
                                        partielle, des éléments du site, quel qu'en soit le support ou le procédé
                                        utilisé, est interdite sans autorisation écrite préalable de l'éditeur.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Marques et signes distinctifs
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Les dénominations, logos "JaaJ FM" et
                                        autres signes utilisés sur ce site sont des marques et/ou noms commerciaux
                                        légalement protégés. Tout usage de ceux-ci ou de signes ressemblants est
                                        strictement interdit sans un accord préalable et écrit.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Contenu musical des
                                        utilisateurs</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Les utilisateurs garantissent :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Être propriétaires des droits d'auteur sur les œuvres musicales qu'ils
                                            partagent</li>
                                        <li>Que leurs créations sont libres de droits ou qu'ils détiennent les
                                            autorisations nécessaires</li>
                                        <li>Ne pas porter atteinte aux droits de propriété intellectuelle de tiers</li>
                                    </ul>

                                    <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-4 mb-4">
                                        <p class="text-yellow-200 font-semibold mb-2">ATTENTION :</p>
                                        <p class="text-white/90 text-sm">Conformément à la législation belge sur le
                                            droit d'auteur, tout contenu musical protégé ne peut être diffusé sans
                                            l'autorisation des ayants droit. Les utilisateurs s'engagent à respecter le
                                            droit d'auteur et les droits voisins.</p>
                                    </div>

                                    <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 mb-4">
                                        <p class="text-red-200 font-semibold mb-2">LIMITATION DE RESPONSABILITÉ :</p>
                                        <p class="text-white/90 text-sm mb-3">JaaJ FM agit en qualité d'hébergeur de
                                            contenus générés par les utilisateurs. Conformément à la Directive
                                            européenne sur le commerce électronique et au droit belge, nous ne sommes
                                            pas responsables des contenus illégaux (notamment les violations de droits
                                            d'auteur) publiés par les utilisateurs, à condition que :</p>
                                        <ul class="text-white/90 text-sm list-disc list-inside space-y-1 ml-4 mb-3">
                                            <li>Nous n'ayons pas une connaissance effective de l'activité ou de
                                                l'information illicites</li>
                                            <li>Nous agissions promptement pour retirer ou rendre inaccessible le
                                                contenu dès que nous en avons connaissance</li>
                                        </ul>
                                        <p class="text-white/90 text-sm">L'utilisateur qui publie un contenu musical non
                                            libre de droits engage sa seule et entière responsabilité. En cas de
                                            réclamation ou de procédure judiciaire relative à une violation de droits
                                            d'auteur, l'utilisateur s'engage à garantir et indemniser JaaJ FM de toute
                                            condamnation, réclamation, coût ou dépense qui pourrait en résulter.</p>
                                    </div>

                                    <p class="text-white/90 leading-relaxed"><strong>Procédure de notification
                                            :</strong> Tout ayant droit estimant qu'un contenu porte atteinte à ses
                                        droits peut nous en informer via contact@jaajfm.com, nous procéderons alors à
                                        l'examen et, le cas échéant, au retrait rapide du contenu litigieux.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3 mt-6">Musiques générées par IA
                                    </h3>
                                    <p class="text-white/90 leading-relaxed">Les musiques générées par intelligence
                                        artificielle doivent être clairement identifiées comme telles. L'utilisateur
                                        garantit que le processus de génération n'utilise pas d'œuvres protégées sans
                                        autorisation.</p>
                                </div>

                                <!-- Responsabilité quant au contenu -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Responsabilité quant au contenu
                                    </h2>
                                    <p class="text-white/90 leading-relaxed mb-4">J'apporte le plus grand soin à la
                                        création et à la mise à jour de ce site mais je ne peux toutefois pas garantir
                                        l'exactitude de toutes les informations qui s'y trouvent. Les informations
                                        contenues dans ce site pourront faire l'objet de modifications sans préavis.</p>
                                    <p class="text-white/90 leading-relaxed mb-4">Les informations données sur ce site
                                        ne sauraient engager ma responsabilité, je ne pourrais être tenu responsable de
                                        toute omission, erreur ou lacune qui aurait pu se glisser dans ses pages ainsi
                                        que des conséquences, quelles qu'elles soient, pouvant résulter de l'utilisation
                                        des informations et indications fournies.</p>
                                    <p class="text-white/90 leading-relaxed">JaaJ FM ne peut être tenu responsable des
                                        dommages, directs ou indirects, quelle qu'en soit la nature, qui découleraient
                                        de l'usage du présent site (exemple : virus, fichiers endommagés, perte de
                                        programmes ou autres données, etc.).</p>
                                </div>

                                <!-- Liens hypertextes -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Liens hypertextes</h2>
                                    <p class="text-white/90 leading-relaxed mb-4">Le site web de JaaJ FM est susceptible
                                        de contenir des liens vers d'autres sites web. Je n'ai toutefois de contrôle que
                                        sur les sites de mon domaine jaajfm.com. Je m'engage toutefois à retirer dans
                                        les plus brefs délais tout lien hypertexte vers un site dont j'apprendrais que
                                        le contenu est illégal.</p>
                                </div>

                                <!-- Protection des données personnelles -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Protection des données
                                        personnelles (RGPD)</h2>

                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-4 mb-4">
                                        <p class="text-blue-200 font-semibold mb-2">Note importante :</p>
                                        <p class="text-white/90 text-sm">Pour une information complète sur le traitement
                                            de vos données personnelles, veuillez consulter notre Politique de
                                            Confidentialité dédiée.</p>
                                    </div>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Responsable du traitement
                                    </h3>
                                    <div class="text-white/90 leading-relaxed space-y-2 mb-4">
                                        <p><strong>Nom :</strong> Cyril Mignon</p>
                                        <p><strong>Qualité :</strong> Particulier, éditeur du site JaaJ FM</p>
                                        <p><strong>Localisation :</strong> Ottignies, Belgique</p>
                                        <p><strong>Email :</strong> contact@jaajfm.com</p>
                                        <p class="text-sm text-white/70">Note : En tant que particulier, la désignation
                                            d'un Délégué à la Protection des Données (DPO) n'est pas obligatoire.</p>
                                    </div>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Données collectées</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Dans le cadre du fonctionnement de
                                        JaaJ FM, nous collectons et traitons les données personnelles suivantes :</p>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Données d'inscription :</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Nom d'utilisateur</li>
                                        <li>Adresse email</li>
                                        <li>Mot de passe (crypté)</li>
                                        <li>Date de création du compte</li>
                                    </ul>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Données d'utilisation :</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Adresse IP</li>
                                        <li>Données de connexion et de navigation</li>
                                        <li>Interactions avec le contenu (likes, commentaires, partages)</li>
                                        <li>Historique d'écoute</li>
                                        <li>Préférences musicales</li>
                                    </ul>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Données de contenu :</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Fichiers musicaux uploadés</li>
                                        <li>Métadonnées associées (titre, genre, description)</li>
                                        <li>Commentaires et publications</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Finalités du traitement</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Vos données personnelles sont traitées
                                        pour :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>La création et gestion de votre compte utilisateur</li>
                                        <li>La fourniture des services de la plateforme</li>
                                        <li>La personnalisation de votre expérience</li>
                                        <li>L'amélioration de nos services</li>
                                        <li>La communication avec vous</li>
                                        <li>Le respect de nos obligations légales</li>
                                        <li>La sécurité de la plateforme</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Base légale du traitement
                                    </h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Consentement :</strong> pour l'inscription et l'utilisation des
                                            services</li>
                                        <li><strong>Exécution d'un contrat :</strong> pour la fourniture des services
                                        </li>
                                        <li><strong>Intérêt légitime :</strong> pour l'amélioration des services et la
                                            sécurité</li>
                                        <li><strong>Obligation légale :</strong> pour le respect des obligations légales
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Durée de conservation</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Comptes actifs :</strong> pendant toute la durée d'utilisation du
                                            service</li>
                                        <li><strong>Comptes inactifs :</strong> 3 ans après la dernière connexion</li>
                                        <li><strong>Données de navigation :</strong> 13 mois maximum</li>
                                        <li><strong>Données de sauvegarde :</strong> 1 an après suppression du compte
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Vos droits</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Conformément au RGPD, vous disposez
                                        des droits suivants :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Droit d'accès :</strong> consulter vos données personnelles</li>
                                        <li><strong>Droit de rectification :</strong> corriger vos données inexactes
                                        </li>
                                        <li><strong>Droit à l'effacement :</strong> supprimer vos données (sous
                                            conditions)</li>
                                        <li><strong>Droit à la limitation :</strong> limiter certains traitements</li>
                                        <li><strong>Droit à la portabilité :</strong> récupérer vos données</li>
                                        <li><strong>Droit d'opposition :</strong> vous opposer à certains traitements
                                        </li>
                                        <li><strong>Droit de retrait du consentement :</strong> à tout moment</li>
                                    </ul>

                                    <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4 mb-4">
                                        <p class="text-green-200 font-semibold mb-2">Pour exercer vos droits,
                                            contactez-nous à :</p>
                                        <p class="text-white/90 text-sm">contact@jaajfm.com</p>
                                        <p class="text-white/90 text-sm mt-2">Important : En tant que particulier gérant
                                            ce site, je traiterai votre demande dans les meilleurs délais et au maximum
                                            dans le mois légal. Merci de joindre une pièce d'identité pour des raisons
                                            de sécurité.</p>
                                    </div>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Destinataires des données
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Vos données peuvent être partagées
                                        avec :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Les prestataires techniques (hébergement, maintenance)</li>
                                        <li>Les autorités légales si requis par la loi</li>
                                        <li>Les partenaires pour les fonctionnalités intégrées (avec votre consentement)
                                        </li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Transferts internationaux
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Certaines données peuvent être
                                        transférées vers des pays tiers dans le cadre de l'utilisation de services
                                        externes. Ces transferts sont encadrés par des garanties appropriées (clauses
                                        contractuelles types, décisions d'adéquation).</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Sécurité des données</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">Nous mettons en place des mesures
                                        techniques et organisationnelles appropriées pour protéger vos données
                                        personnelles contre :</p>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>L'accès non autorisé</li>
                                        <li>La modification, divulgation ou destruction</li>
                                        <li>La perte accidentelle</li>
                                        <li>Le traitement illicite</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Autorité de contrôle</h3>
                                    <p class="text-white/90 leading-relaxed mb-3">En cas de litige, vous pouvez saisir
                                        l'Autorité de Protection des Données (APD) :</p>
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-4">
                                        <p class="text-blue-200 font-semibold mb-2">Autorité de Protection des Données
                                        </p>
                                        <p class="text-white/90 text-sm">Rue de la Presse 35, 1000 Bruxelles</p>
                                        <p class="text-white/90 text-sm">Tél : +32 (0)2 274 48 00</p>
                                        <p class="text-white/90 text-sm">Email : contact@apd-gba.be</p>
                                        <p class="text-white/90 text-sm">Site : www.autoriteprotectiondonnees.be</p>
                                    </div>
                                </div>

                                <!-- Politique des cookies -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Politique des cookies</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Définition</h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Les cookies sont de petits fichiers
                                        texte stockés sur votre appareil lors de votre visite sur notre site.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Types de cookies utilisés
                                    </h3>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Cookies techniques
                                        (obligatoires) :</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Gestion de session utilisateur</li>
                                        <li>Préférences d'affichage</li>
                                        <li>Sécurité de navigation</li>
                                        <li>Fonctionnement de base du site</li>
                                    </ul>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Cookies de performance (avec
                                        consentement) :</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Statistiques de fréquentation</li>
                                        <li>Analyse des performances</li>
                                        <li>Amélioration de l'expérience utilisateur</li>
                                    </ul>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Cookies publicitaires (avec
                                        consentement) :</h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Personnalisation des publicités</li>
                                        <li>Mesure d'efficacité publicitaire</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Gestion des cookies</h3>
                                    <p class="text-white/90 leading-relaxed mb-4">Vous pouvez configurer vos préférences
                                        de cookies via notre bandeau de consentement ou dans les paramètres de votre
                                        navigateur.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Durée de conservation des
                                        cookies</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li><strong>Cookies de session :</strong> supprimés à la fermeture du navigateur
                                        </li>
                                        <li><strong>Cookies persistants :</strong> 13 mois maximum</li>
                                    </ul>
                                </div>

                                <!-- Conditions générales d'utilisation -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Conditions générales
                                        d'utilisation</h2>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Acceptation des conditions
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-4">L'utilisation de JaaJ FM implique
                                        l'acceptation pleine et entière de ces conditions générales d'utilisation.</p>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Accès au service</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Le service est accessible 24h/24, 7j/7, sauf cas de force majeure</li>
                                        <li>Une maintenance programmée peut interrompre temporairement le service</li>
                                        <li>L'accès nécessite une connexion internet et un navigateur compatible</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Inscription</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>L'inscription est gratuite et ouverte aux personnes de plus de 13 ans</li>
                                        <li>Les informations fournies doivent être exactes et tenues à jour</li>
                                        <li>Un seul compte par personne physique est autorisé</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Utilisation du service</h3>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Utilisations autorisées :
                                    </h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Partager des créations musicales originales</li>
                                        <li>Écouter et découvrir de la musique</li>
                                        <li>Interagir avec la communauté de manière respectueuse</li>
                                        <li>Participer aux classements et concours</li>
                                    </ul>

                                    <h4 class="text-lg font-semibold text-purple-100 mb-2">Utilisations interdites :
                                    </h4>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Partager du contenu illégal, diffamatoire ou offensant</li>
                                        <li>Violer les droits d'auteur ou de propriété intellectuelle</li>
                                        <li>Utiliser des systèmes automatisés pour manipuler les classements</li>
                                        <li>Harceler ou intimider d'autres utilisateurs</li>
                                        <li>Diffuser des virus ou codes malveillants</li>
                                        <li>Créer de faux comptes ou usurper l'identité d'autrui</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Modération</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Nous nous réservons le droit de modérer les contenus</li>
                                        <li>Les contenus inappropriés peuvent être supprimés sans préavis</li>
                                        <li>Les comptes violant les conditions peuvent être suspendus ou supprimés</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Responsabilité</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>L'utilisateur est seul responsable du contenu qu'il publie</li>
                                        <li>JaaJ FM ne peut être tenu responsable des contenus publiés par les
                                            utilisateurs</li>
                                        <li>Nous déclinons toute responsabilité en cas de perte de données</li>
                                    </ul>

                                    <h3 class="text-xl font-semibold text-purple-200 mb-3">Résiliation</h3>
                                    <ul class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-4">
                                        <li>Vous pouvez supprimer votre compte à tout moment</li>
                                        <li>Nous pouvons suspendre ou supprimer un compte en cas de violation des
                                            conditions</li>
                                        <li>La résiliation entraîne la suppression définitive du contenu associé</li>
                                    </ul>
                                </div>

                                <!-- Droit applicable et juridiction -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Droit applicable et juridiction
                                    </h2>
                                    <p class="text-white/90 leading-relaxed mb-4">Le présent site est régi par le droit
                                        belge. En cas de litige, les tribunaux belges sont seuls compétents, sauf
                                        dispositions légales contraires ou accord contraire des parties pour un
                                        règlement amiable.</p>
                                </div>

                                <!-- Contact et réclamations -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Contact et réclamations</h2>
                                    <p class="text-white/90 leading-relaxed mb-4">Pour toute question concernant ces
                                        mentions légales, nos pratiques de confidentialité ou l'exercice de vos droits,
                                        vous pouvez nous contacter :</p>

                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-4 mb-4">
                                        <p class="text-blue-200 font-semibold mb-2">Contact :</p>
                                        <p class="text-white/90 text-sm"><strong>Email :</strong> contact@jaajfm.com</p>
                                        <p class="text-white/90 text-sm"><strong>Adresse postale :</strong> Cyril
                                            Mignon, Ottignies, Belgique</p>
                                        <p class="text-white/90 text-sm mt-2">Note : En tant que particulier, je
                                            m'engage à traiter vos demandes dans les meilleurs délais.</p>
                                    </div>
                                </div>

                                <!-- Modification des mentions légales -->
                                <div class="bg-white/10 rounded-xl p-6">
                                    <h2 class="text-2xl font-bold text-purple-300 mb-4">Modification des mentions
                                        légales</h2>
                                    <p class="text-white/90 leading-relaxed mb-4">Je me réserve le droit de modifier ou
                                        de mettre à jour à tout moment les informations contenues sur ce site ainsi que
                                        les présentes mentions légales, et ce sans notification préalable. Les
                                        utilisateurs seront informés des modifications importantes par notification sur
                                        la plateforme.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <!-- Version Mobile -->
        <div class="md:hidden">
            <!-- Header Mobile -->
            <MobilePageHeader title="Mentions Légales" />

            <!-- Contenu Mobile -->
            <main class="pt-20 pb-20">
                <div class="px-4 py-6 space-y-6">
                    <!-- Section Mentions Légales -->
                    <section class="glass rounded-2xl p-6">
                        <div class="flex items-center gap-4 mb-6">
                            <button @click="goBack" class="text-white hover:text-purple-300 transition-colors">
                                <ArrowLeftIcon class="w-5 h-5" />
                            </button>
                            <h1 class="text-2xl font-bold text-white">Mentions Légales</h1>
                        </div>

                        <div class="prose prose-invert max-w-none">
                            <div class="text-white space-y-6">
                                <!-- Éditeur du site -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Éditeur du site</h2>
                                    <div class="text-white/90 leading-relaxed space-y-2 text-sm">
                                        <p><strong>Statut :</strong> Particulier - Site personnel non-commercial</p>
                                        <p><strong>Nom :</strong> Cyril Mignon</p>
                                        <p><strong>Localisation :</strong> Ottignies, Belgique</p>
                                        <p><strong>Contact :</strong> contact@jaajfm.com</p>
                                        <p><strong>Site web :</strong> www.jaajfm.com</p>
                                        <p class="text-xs text-white/70">Note : Les données complètes d'identification
                                            de l'éditeur ont été transmises à l'hébergeur conformément à la
                                            réglementation belge.</p>
                                    </div>
                                </div>

                                <!-- Hébergeur du site -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Hébergeur du site</h2>
                                    <div class="text-white/90 leading-relaxed space-y-2 text-sm">
                                        <p><strong>Nom de l'hébergeur :</strong> o2switch</p>
                                        <p><strong>Adresse :</strong> 222-224 Boulevard Gustave Flaubert, 63000
                                            Clermont-Ferrand, France</p>
                                        <p><strong>Téléphone :</strong> 04 44 44 60 40</p>
                                        <p><strong>Site web :</strong> www.o2switch.fr</p>
                                        <p class="text-xs text-white/70">Note : Conformément à la législation, les
                                            données complètes d'identification de l'éditeur ont été transmises à
                                            l'hébergeur.</p>
                                    </div>
                                </div>

                                <!-- Objet du site -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Objet du site</h2>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">JaaJ FM est une plateforme de
                                        réseau social musical permettant aux utilisateurs de :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 text-sm">
                                        <li>Partager des créations musicales (générées par IA ou traditionnelles)</li>
                                        <li>Découvrir de nouvelles musiques</li>
                                        <li>Participer à des classements communautaires</li>
                                        <li>Écouter une radio en direct</li>
                                        <li>Interagir avec une communauté de créateurs musicaux</li>
                                    </ul>
                                </div>

                                <!-- Propriété intellectuelle -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Propriété intellectuelle et
                                        droits d'auteur</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Contenu du site JaaJ FM</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Le site JaaJ FM constitue une
                                        création protégée par le droit d'auteur. Tous les éléments du site JaaJ FM
                                        (design, structure, logos, textes, images, sons, vidéos, interface, etc.) sont
                                        la propriété exclusive de Cyril Mignon ou font l'objet de licences
                                        d'utilisation, sauf mention contraire.</p>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Toute reproduction,
                                        représentation, modification, publication, adaptation, transmission ou
                                        diffusion, totale ou partielle, des éléments du site, quel qu'en soit le support
                                        ou le procédé utilisé, est interdite sans autorisation écrite préalable de
                                        l'éditeur.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Marques et signes distinctifs
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Les dénominations, logos "JaaJ
                                        FM" et autres signes utilisés sur ce site sont des marques et/ou noms
                                        commerciaux légalement protégés. Tout usage de ceux-ci ou de signes ressemblants
                                        est strictement interdit sans un accord préalable et écrit.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Contenu musical des
                                        utilisateurs</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Les utilisateurs garantissent
                                        :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Être propriétaires des droits d'auteur sur les œuvres musicales qu'ils
                                            partagent</li>
                                        <li>Que leurs créations sont libres de droits ou qu'ils détiennent les
                                            autorisations nécessaires</li>
                                        <li>Ne pas porter atteinte aux droits de propriété intellectuelle de tiers</li>
                                    </ul>

                                    <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-3 mb-3">
                                        <p class="text-yellow-200 font-semibold mb-1 text-sm">ATTENTION :</p>
                                        <p class="text-white/90 text-xs">Conformément à la législation belge sur le
                                            droit d'auteur, tout contenu musical protégé ne peut être diffusé sans
                                            l'autorisation des ayants droit. Les utilisateurs s'engagent à respecter le
                                            droit d'auteur et les droits voisins.</p>
                                    </div>

                                    <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-3 mb-3">
                                        <p class="text-red-200 font-semibold mb-1 text-sm">LIMITATION DE RESPONSABILITÉ
                                            :</p>
                                        <p class="text-white/90 text-xs mb-2">JaaJ FM agit en qualité d'hébergeur de
                                            contenus générés par les utilisateurs. Conformément à la Directive
                                            européenne sur le commerce électronique et au droit belge, nous ne sommes
                                            pas responsables des contenus illégaux (notamment les violations de droits
                                            d'auteur) publiés par les utilisateurs, à condition que :</p>
                                        <ul class="text-white/90 text-xs list-disc list-inside space-y-1 ml-4 mb-2">
                                            <li>Nous n'ayons pas une connaissance effective de l'activité ou de
                                                l'information illicites</li>
                                            <li>Nous agissions promptement pour retirer ou rendre inaccessible le
                                                contenu dès que nous en avons connaissance</li>
                                        </ul>
                                        <p class="text-white/90 text-xs">L'utilisateur qui publie un contenu musical non
                                            libre de droits engage sa seule et entière responsabilité. En cas de
                                            réclamation ou de procédure judiciaire relative à une violation de droits
                                            d'auteur, l'utilisateur s'engage à garantir et indemniser JaaJ FM de toute
                                            condamnation, réclamation, coût ou dépense qui pourrait en résulter.</p>
                                    </div>

                                    <p class="text-white/90 leading-relaxed text-sm"><strong>Procédure de notification
                                            :</strong> Tout ayant droit estimant qu'un contenu porte atteinte à ses
                                        droits peut nous en informer via contact@jaajfm.com, nous procéderons alors à
                                        l'examen et, le cas échéant, au retrait rapide du contenu litigieux.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2 mt-4">Musiques générées par IA
                                    </h3>
                                    <p class="text-white/90 leading-relaxed text-sm">Les musiques générées par
                                        intelligence artificielle doivent être clairement identifiées comme telles.
                                        L'utilisateur garantit que le processus de génération n'utilise pas d'œuvres
                                        protégées sans autorisation.</p>
                                </div>

                                <!-- Responsabilité quant au contenu -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Responsabilité quant au contenu
                                    </h2>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">J'apporte le plus grand soin à
                                        la création et à la mise à jour de ce site mais je ne peux toutefois pas
                                        garantir l'exactitude de toutes les informations qui s'y trouvent. Les
                                        informations contenues dans ce site pourront faire l'objet de modifications sans
                                        préavis.</p>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Les informations données sur
                                        ce site ne sauraient engager ma responsabilité, je ne pourrais être tenu
                                        responsable de toute omission, erreur ou lacune qui aurait pu se glisser dans
                                        ses pages ainsi que des conséquences, quelles qu'elles soient, pouvant résulter
                                        de l'utilisation des informations et indications fournies.</p>
                                    <p class="text-white/90 leading-relaxed text-sm">JaaJ FM ne peut être tenu
                                        responsable des dommages, directs ou indirects, quelle qu'en soit la nature, qui
                                        découleraient de l'usage du présent site (exemple : virus, fichiers endommagés,
                                        perte de programmes ou autres données, etc.).</p>
                                </div>

                                <!-- Liens hypertextes -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Liens hypertextes</h2>
                                    <p class="text-white/90 leading-relaxed text-sm">Le site web de JaaJ FM est
                                        susceptible de contenir des liens vers d'autres sites web. Je n'ai toutefois de
                                        contrôle que sur les sites de mon domaine jaajfm.com. Je m'engage toutefois à
                                        retirer dans les plus brefs délais tout lien hypertexte vers un site dont
                                        j'apprendrais que le contenu est illégal.</p>
                                </div>

                                <!-- Protection des données personnelles -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Protection des données
                                        personnelles (RGPD)</h2>

                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-3 mb-3">
                                        <p class="text-blue-200 font-semibold mb-1 text-sm">Note importante :</p>
                                        <p class="text-white/90 text-xs">Pour une information complète sur le traitement
                                            de vos données personnelles, veuillez consulter notre Politique de
                                            Confidentialité dédiée.</p>
                                    </div>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Responsable du traitement
                                    </h3>
                                    <div class="text-white/90 leading-relaxed space-y-2 mb-3 text-sm">
                                        <p><strong>Nom :</strong> Cyril Mignon</p>
                                        <p><strong>Qualité :</strong> Particulier, éditeur du site JaaJ FM</p>
                                        <p><strong>Localisation :</strong> Ottignies, Belgique</p>
                                        <p><strong>Email :</strong> contact@jaajfm.com</p>
                                        <p class="text-xs text-white/70">Note : En tant que particulier, la désignation
                                            d'un Délégué à la Protection des Données (DPO) n'est pas obligatoire.</p>
                                    </div>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Données collectées</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Dans le cadre du
                                        fonctionnement de JaaJ FM, nous collectons et traitons les données personnelles
                                        suivantes :</p>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Données d'inscription :
                                    </h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Nom d'utilisateur</li>
                                        <li>Adresse email</li>
                                        <li>Mot de passe (crypté)</li>
                                        <li>Date de création du compte</li>
                                    </ul>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Données d'utilisation :
                                    </h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Adresse IP</li>
                                        <li>Données de connexion et de navigation</li>
                                        <li>Interactions avec le contenu (likes, commentaires, partages)</li>
                                        <li>Historique d'écoute</li>
                                        <li>Préférences musicales</li>
                                    </ul>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Données de contenu :</h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Fichiers musicaux uploadés</li>
                                        <li>Métadonnées associées (titre, genre, description)</li>
                                        <li>Commentaires et publications</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Finalités du traitement</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Vos données personnelles sont
                                        traitées pour :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>La création et gestion de votre compte utilisateur</li>
                                        <li>La fourniture des services de la plateforme</li>
                                        <li>La personnalisation de votre expérience</li>
                                        <li>L'amélioration de nos services</li>
                                        <li>La communication avec vous</li>
                                        <li>Le respect de nos obligations légales</li>
                                        <li>La sécurité de la plateforme</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Base légale du traitement
                                    </h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Consentement :</strong> pour l'inscription et l'utilisation des
                                            services</li>
                                        <li><strong>Exécution d'un contrat :</strong> pour la fourniture des services
                                        </li>
                                        <li><strong>Intérêt légitime :</strong> pour l'amélioration des services et la
                                            sécurité</li>
                                        <li><strong>Obligation légale :</strong> pour le respect des obligations légales
                                        </li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Durée de conservation</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Comptes actifs :</strong> pendant toute la durée d'utilisation du
                                            service</li>
                                        <li><strong>Comptes inactifs :</strong> 3 ans après la dernière connexion</li>
                                        <li><strong>Données de navigation :</strong> 13 mois maximum</li>
                                        <li><strong>Données de sauvegarde :</strong> 1 an après suppression du compte
                                        </li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Vos droits</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Conformément au RGPD, vous
                                        disposez des droits suivants :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Droit d'accès :</strong> consulter vos données personnelles</li>
                                        <li><strong>Droit de rectification :</strong> corriger vos données inexactes
                                        </li>
                                        <li><strong>Droit à l'effacement :</strong> supprimer vos données (sous
                                            conditions)</li>
                                        <li><strong>Droit à la limitation :</strong> limiter certains traitements</li>
                                        <li><strong>Droit à la portabilité :</strong> récupérer vos données</li>
                                        <li><strong>Droit d'opposition :</strong> vous opposer à certains traitements
                                        </li>
                                        <li><strong>Droit de retrait du consentement :</strong> à tout moment</li>
                                    </ul>

                                    <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-3 mb-3">
                                        <p class="text-green-200 font-semibold mb-1 text-sm">Pour exercer vos droits,
                                            contactez-nous à :</p>
                                        <p class="text-white/90 text-xs">contact@jaajfm.com</p>
                                        <p class="text-white/90 text-xs mt-2">Important : En tant que particulier gérant
                                            ce site, je traiterai votre demande dans les meilleurs délais et au maximum
                                            dans le mois légal. Merci de joindre une pièce d'identité pour des raisons
                                            de sécurité.</p>
                                    </div>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Destinataires des données
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Vos données peuvent être
                                        partagées avec :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Les prestataires techniques (hébergement, maintenance)</li>
                                        <li>Les autorités légales si requis par la loi</li>
                                        <li>Les partenaires pour les fonctionnalités intégrées (avec votre consentement)
                                        </li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Transferts internationaux
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Certaines données peuvent être
                                        transférées vers des pays tiers dans le cadre de l'utilisation de services
                                        externes. Ces transferts sont encadrés par des garanties appropriées (clauses
                                        contractuelles types, décisions d'adéquation).</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Sécurité des données</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">Nous mettons en place des
                                        mesures techniques et organisationnelles appropriées pour protéger vos données
                                        personnelles contre :</p>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>L'accès non autorisé</li>
                                        <li>La modification, divulgation ou destruction</li>
                                        <li>La perte accidentelle</li>
                                        <li>Le traitement illicite</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Autorité de contrôle</h3>
                                    <p class="text-white/90 leading-relaxed mb-2 text-sm">En cas de litige, vous pouvez
                                        saisir l'Autorité de Protection des Données (APD) :</p>
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-3">
                                        <p class="text-blue-200 font-semibold mb-1 text-sm">Autorité de Protection des
                                            Données</p>
                                        <p class="text-white/90 text-xs">Rue de la Presse 35, 1000 Bruxelles</p>
                                        <p class="text-white/90 text-xs">Tél : +32 (0)2 274 48 00</p>
                                        <p class="text-white/90 text-xs">Email : contact@apd-gba.be</p>
                                        <p class="text-white/90 text-xs">Site : www.autoriteprotectiondonnees.be</p>
                                    </div>
                                </div>

                                <!-- Politique des cookies -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Politique des cookies</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Définition</h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Les cookies sont de petits
                                        fichiers texte stockés sur votre appareil lors de votre visite sur notre site.
                                    </p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Types de cookies utilisés
                                    </h3>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Cookies techniques
                                        (obligatoires) :</h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Gestion de session utilisateur</li>
                                        <li>Préférences d'affichage</li>
                                        <li>Sécurité de navigation</li>
                                        <li>Fonctionnement de base du site</li>
                                    </ul>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Cookies de performance
                                        (avec consentement) :</h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Statistiques de fréquentation</li>
                                        <li>Analyse des performances</li>
                                        <li>Amélioration de l'expérience utilisateur</li>
                                    </ul>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Cookies publicitaires (avec
                                        consentement) :</h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Personnalisation des publicités</li>
                                        <li>Mesure d'efficacité publicitaire</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Gestion des cookies</h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Vous pouvez configurer vos
                                        préférences de cookies via notre bandeau de consentement ou dans les paramètres
                                        de votre navigateur.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Durée de conservation des
                                        cookies</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li><strong>Cookies de session :</strong> supprimés à la fermeture du navigateur
                                        </li>
                                        <li><strong>Cookies persistants :</strong> 13 mois maximum</li>
                                    </ul>
                                </div>

                                <!-- Conditions générales d'utilisation -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Conditions générales
                                        d'utilisation</h2>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Acceptation des conditions
                                    </h3>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">L'utilisation de JaaJ FM
                                        implique l'acceptation pleine et entière de ces conditions générales
                                        d'utilisation.</p>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Accès au service</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Le service est accessible 24h/24, 7j/7, sauf cas de force majeure</li>
                                        <li>Une maintenance programmée peut interrompre temporairement le service</li>
                                        <li>L'accès nécessite une connexion internet et un navigateur compatible</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Inscription</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>L'inscription est gratuite et ouverte aux personnes de plus de 13 ans</li>
                                        <li>Les informations fournies doivent être exactes et tenues à jour</li>
                                        <li>Un seul compte par personne physique est autorisé</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Utilisation du service</h3>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Utilisations autorisées :
                                    </h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Partager des créations musicales originales</li>
                                        <li>Écouter et découvrir de la musique</li>
                                        <li>Interagir avec la communauté de manière respectueuse</li>
                                        <li>Participer aux classements et concours</li>
                                    </ul>

                                    <h4 class="text-base font-semibold text-purple-100 mb-1">Utilisations interdites :
                                    </h4>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Partager du contenu illégal, diffamatoire ou offensant</li>
                                        <li>Violer les droits d'auteur ou de propriété intellectuelle</li>
                                        <li>Utiliser des systèmes automatisés pour manipuler les classements</li>
                                        <li>Harceler ou intimider d'autres utilisateurs</li>
                                        <li>Diffuser des virus ou codes malveillants</li>
                                        <li>Créer de faux comptes ou usurper l'identité d'autrui</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Modération</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Nous nous réservons le droit de modérer les contenus</li>
                                        <li>Les contenus inappropriés peuvent être supprimés sans préavis</li>
                                        <li>Les comptes violant les conditions peuvent être suspendus ou supprimés</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Responsabilité</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>L'utilisateur est seul responsable du contenu qu'il publie</li>
                                        <li>JaaJ FM ne peut être tenu responsable des contenus publiés par les
                                            utilisateurs</li>
                                        <li>Nous déclinons toute responsabilité en cas de perte de données</li>
                                    </ul>

                                    <h3 class="text-lg font-semibold text-purple-200 mb-2">Résiliation</h3>
                                    <ul
                                        class="text-white/90 leading-relaxed list-disc list-inside space-y-1 ml-4 mb-3 text-sm">
                                        <li>Vous pouvez supprimer votre compte à tout moment</li>
                                        <li>Nous pouvons suspendre ou supprimer un compte en cas de violation des
                                            conditions</li>
                                        <li>La résiliation entraîne la suppression définitive du contenu associé</li>
                                    </ul>
                                </div>

                                <!-- Droit applicable et juridiction -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Droit applicable et juridiction
                                    </h2>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Le présent site est régi par
                                        le droit belge. En cas de litige, les tribunaux belges sont seuls compétents,
                                        sauf dispositions légales contraires ou accord contraire des parties pour un
                                        règlement amiable.</p>
                                </div>

                                <!-- Contact et réclamations -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Contact et réclamations</h2>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Pour toute question concernant
                                        ces mentions légales, nos pratiques de confidentialité ou l'exercice de vos
                                        droits, vous pouvez nous contacter :</p>

                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-3 mb-3">
                                        <p class="text-blue-200 font-semibold mb-1 text-sm">Contact :</p>
                                        <p class="text-white/90 text-xs"><strong>Email :</strong> contact@jaajfm.com</p>
                                        <p class="text-white/90 text-xs"><strong>Adresse postale :</strong> Cyril
                                            Mignon, Ottignies, Belgique</p>
                                        <p class="text-white/90 text-xs mt-2">Note : En tant que particulier, je
                                            m'engage à traiter vos demandes dans les meilleurs délais.</p>
                                    </div>
                                </div>

                                <!-- Modification des mentions légales -->
                                <div class="bg-white/10 rounded-xl p-4">
                                    <h2 class="text-xl font-bold text-purple-300 mb-3">Modification des mentions légales
                                    </h2>
                                    <p class="text-white/90 leading-relaxed mb-3 text-sm">Je me réserve le droit de
                                        modifier ou de mettre à jour à tout moment les informations contenues sur ce
                                        site ainsi que les présentes mentions légales, et ce sans notification
                                        préalable. Les utilisateurs seront informés des modifications importantes par
                                        notification sur la plateforme.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>

            <!-- Navigation Mobile -->
            <MobileNavigation />
        </div>
    </div>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'
import Sidebar from '@/Components/Sidebar.vue'
import Header from '@/Components/Header.vue'
import MobilePageHeader from '@/Components/MobilePageHeader.vue'
import MobileNavigation from '@/Components/MobileNavigation.vue'

// Méthodes
const goBack = () => {
    router.visit('/')
}

const handleLiveRadioToggle = (isPlaying) => {
    // Gérer le toggle de la radio live
}
</script>

<style scoped>
.glass {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0px);
    }

    50% {
        transform: translateY(-20px);
    }
}

@keyframes float-reverse {

    0%,
    100% {
        transform: translateY(0px) rotate(45deg);
    }

    50% {
        transform: translateY(20px) rotate(45deg);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-reverse {
    animation: float-reverse 8s ease-in-out infinite;
}
</style>
