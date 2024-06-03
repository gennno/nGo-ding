import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:introduction_screen/introduction_screen.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:logger/logger.dart';
import 'package:wmk/screen/login_screen.dart';

int introduction = 0;

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  SystemChrome.setSystemUIOverlayStyle(
    SystemUiOverlayStyle.dark.copyWith(statusBarColor: Colors.transparent),
  );
  runApp(const MyApp());
}

final logger = Logger(); // Buat objek Logger

Future initIntroduction() async {
  final prefs = await SharedPreferences.getInstance();

  int? intro = prefs.getInt('introduction');
  logger.i('intro : $intro'); // Gunakan objek logger untuk memanggil metode i

  if (intro != null && intro == 1) {
    return introduction = 1;
  }
  prefs.setInt('introduction', 1);
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Flutter Demo',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      routes: const {
        // '/': (context) => introduction == 0 ? MyHomePage(title: 'Introduction') : DashboardScreen(),
        // '/course': (context) => CourseScreen(), // Menambahkan rute untuk Course
        // '/progress': (context) => ProgressScreen(), // Rute untuk halaman Charts
        // '/profile': (context) => ProfileScreen(), // Rute untuk halaman Profile
      },
    );
  }
}

class MyHomePage extends StatefulWidget {
  const MyHomePage({super.key, required this.title});
  final String title;
  @override
  State<MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  Widget build(BuildContext context) {
    const PageDecoration pageDecoration = PageDecoration(
      titleTextStyle: TextStyle(fontSize: 28.0, fontWeight: FontWeight.bold),
      bodyTextStyle: TextStyle(fontSize: 18.0),
      bodyPadding: EdgeInsets.all(16),
      bodyAlignment: Alignment.center,
    );

    return IntroductionScreen(
      globalBackgroundColor: Colors.white,
      pages: [
        PageViewModel(
          title: "Modul Edukasi Digital",
          bodyWidget: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              LayoutBuilder(
                builder: (context, constraints) {
                  return Image.asset(
                    'assets/images/onboarding1.png',
                    width: constraints.maxWidth * 0.8,
                  );
                },
              ),
              const SizedBox(height: 20),
              const Text(
                "Tingkatkan keterampilan Anda dalam kemampuan digital untuk mengoptimalkan kemampuan kita.",
                textAlign: TextAlign.center,
                style: TextStyle(fontSize: 18.0),
              ),
            ],
          ),
          decoration: pageDecoration,
        ),
        PageViewModel(
          title: "Mentor secara Real-Time",
          bodyWidget: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              LayoutBuilder(
                builder: (context, constraints) {
                  return Image.asset(
                    'assets/images/onboarding2.png',
                    width: constraints.maxWidth * 0.8,
                  );
                },
              ),
              const SizedBox(height: 20),
              const Text(
                "Melakukan kegiatan mentoring secara real-time bersama para mentor ahli untuk menyelesaikan masalah kita nanti.",
                textAlign: TextAlign.center,
                style: TextStyle(fontSize: 18.0),
              ),
            ],
          ),
          decoration: pageDecoration,
        ),
        PageViewModel(
          title: "Analisis Statitik keterampilan",
          bodyWidget: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              LayoutBuilder(
                builder: (context, constraints) {
                  return Image.asset(
                    'assets/images/onboarding3.png',
                    width: constraints.maxWidth * 0.8,
                  );
                },
              ),
              const SizedBox(height: 20),
              const Text(
                "Kita dapat mentrack hasil kursus anda dengan melihat statistika keterampilan anda dengan timeline per minggu.",
                textAlign: TextAlign.center,
                style: TextStyle(fontSize: 18.0),
              ),
            ],
          ),
          decoration: pageDecoration,
        ),
        PageViewModel(
          title: "Tempat Belajar Bagi 7,000+ Mahasiswa ",
          bodyWidget: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Container(
                margin: const EdgeInsets.only(
                    bottom: 10), // Sesuaikan jarak dari atas gambar
                child: Image.asset('assets/images/onboarding4.png',
                    width: 350), // Ganti dengan gambar yang sesuai
              ),
              Container(
                width: double.infinity, // Lebar sesuai dengan layar
                padding: const EdgeInsets.all(16),
                child: ElevatedButton(
                  onPressed: () {
                    Navigator.pushReplacement(context, MaterialPageRoute(builder: (builder) {
                      return const LoginScreen();
                    }));
                  },
                  style: ElevatedButton.styleFrom(
                    backgroundColor:  Colors.blue, // Background color
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(16.0), // Rounded corners
                    ),
                  ),
                  child: const Padding(
                    padding: EdgeInsets.symmetric(vertical: 16.0),
                    child: Text(
                      'AYO MULAI!',
                      style: TextStyle(
                        color: Colors.white,
                        fontSize: 15,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                ),
              ),
            ],
          ),
          decoration: pageDecoration.copyWith(
            // Anda dapat menyesuaikan dekorasi lainnya di sini
            bodyAlignment:
                Alignment.center, // Memastikan konten berada di tengah
          ),
        )
      ],
      onDone: () {
        Navigator.pushReplacement(context,
            MaterialPageRoute(builder: (builder) {
          return const LoginScreen();
        }));
      },
      showSkipButton: true,
      showNextButton: true,
      showDoneButton: true,
      showBackButton: false,
      dotsFlex: 3,
      nextFlex: 1,
      back: const Icon(Icons.arrow_back),
      skip: const Text('Lewati', style: TextStyle(fontWeight: FontWeight.w600)),
      next: const Icon(Icons.arrow_forward),
      done: const Text('Done', style: TextStyle(fontWeight: FontWeight.w600)),
      dotsDecorator: const DotsDecorator(
        size: Size(10.0, 10.0),
        color: Color(0xFFBDBDBD),
        activeSize: Size(22.0, 10.0),
        activeShape: RoundedRectangleBorder(
          borderRadius: BorderRadius.all(Radius.circular(25.0)),
        ),
      ),
    );
  }
}
