import 'package:firebase_auth/firebase_auth.dart';
import "package:flutter/material.dart";
import 'package:salomon_bottom_bar/salomon_bottom_bar.dart';

void main()async{
  await FirebaseAuth.instance.signOut();
}
class HomeScreen extends StatelessWidget {
  const HomeScreen({super.key});

  final int _currentIndex = 0;
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: DefaultTabController(
        length: 4,
        child: Scaffold(
          appBar: PreferredSize(
            preferredSize: const Size.fromHeight(0),
            child: Container(),
          ),
          body: const SingleChildScrollView(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                WelcomeCard(),
                SizedBox(height: 16),
                ThreeCardsRow(),
                SizedBox(height: 16),
                CarouselCard(
                  images: [
                    'assets/banner1.jpeg',
                    'assets/banner2.jpeg',
                    'assets/banner3.jpeg',
                  ],
                ),
                SizedBox(height: 16),
                Row(
                  children: [
                    Padding(
                      padding: EdgeInsets.only(left: 16.0),
                      child: Text(
                        'Banner',
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ],
                ),
                SizedBox(height: 16),
                CourseCard(),
              ],
            ),
          ),
          bottomNavigationBar: SalomonBottomBar(
            currentIndex: _currentIndex,
            onTap: (i) {
              switch (i) {
                case 0:
                  Navigator.pushNamed(
                      context, '/'); // Navigasi ke halaman utama
                  break;
                case 1:
                  Navigator.pushNamed(
                      context, '/course'); // Navigasi ke halaman Course
                  break;
                case 2:
                  Navigator.pushNamed(context,
                      '/progress'); // Navigasi ke halaman Charts jika diperlukan
                  break;
                case 3:
                  Navigator.pushNamed(context,
                      '/profile'); // Navigasi ke halaman Profile jika diperlukan
                  break;
              }
            },
            items: [
              SalomonBottomBarItem(
                icon: const Icon(Icons.home),
                title: const Text("Home"),
                selectedColor: Colors.blue,
              ),
              SalomonBottomBarItem(
                icon: const Icon(Icons.bookmark),
                title: const Text("Course"),
                selectedColor: Colors.purple,
              ),
              SalomonBottomBarItem(
                icon: const Icon(Icons.stacked_bar_chart),
                title: const Text("Progress"),
                selectedColor: Colors.orange,
              ),
              SalomonBottomBarItem(
                icon: const Icon(Icons.person),
                title: const Text("Profile"),
                selectedColor: Colors.teal,
              ),
            ],
          ),
        ),
      ),
    );
  }
}

class WelcomeCard extends StatelessWidget {
  const WelcomeCard({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final double screenWidth = MediaQuery.of(context).size.width;

    return Card(
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(15.0),
      ),
      elevation: 4,
      margin: const EdgeInsets.all(16),
      child: SizedBox(
        width: double.infinity,
        child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Row(
              children: [
                CircleAvatar(
                  radius: screenWidth < 400 ? 30 : 40,
                  backgroundImage:
                      const AssetImage('assets/images/alfaturrahman.jpg'),
                ),
                const SizedBox(width: 15),
                Expanded(
                  child: Row(
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            'Hello,',
                            style: TextStyle(
                              fontSize: screenWidth < 400 ? 22 : 24,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          Text(
                            'Welcome back 👋',
                            style: TextStyle(
                              fontSize: screenWidth < 400 ? 22 : 24,
                              // fontWeight: FontWeight.bold,
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(width: 14),
                      // const Spacer(),
                      // Mengatur jarak agar ikon notifikasi berada di tengah
                      ElevatedButton(
                        onPressed: () {
                          FirebaseAuth.instance.signOut();
                          Navigator.pushNamed(context, 'login'); // Untuk menuju ke halaman login
                        },
                        style: ElevatedButton.styleFrom(
                          backgroundColor:
                              Colors.transparent, // Hapus warna latar belakang
                          shadowColor: Colors.transparent, // Hapus bayangan
                        ),
                        child: Icon(
                          Icons.exit_to_app,
                          color: Colors.blue,
                          size: screenWidth < 400 ? 30 : 30,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            )),
      ),
    );
  }
}

class ThreeCardsRow extends StatelessWidget {
  const ThreeCardsRow({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 16),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Expanded(
            flex: 1, // Lebar relatif dari Card 1
            child: Card(
              elevation: 4,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(15.0),
              ),
              child: const SizedBox(
                width: double.infinity,
                height: 150,
                child: Center(
                  child: Text('Card 1'),
                ),
              ),
            ),
          ),
          Flexible(
            flex: 1, // Lebar relatif dari Card 2.1 dan Card 2.2
            child: Column(
              children: [
                Card(
                  elevation: 4,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(15.0),
                  ),
                  child: const SizedBox(
                    width: double.infinity,
                    height: 75,
                    child: Center(
                      child: Text('Card 2.1'),
                    ),
                  ),
                ),
                const SizedBox(
                    height: 16), // Tambahkan ruang antara Card 2.1 dan Card 2.2
                Card(
                  elevation: 4,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(15.0),
                  ),
                  child: const SizedBox(
                    width: double.infinity,
                    height: 75,
                    child: Center(
                      child: Text('Card 2.2'),
                    ),
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class CarouselCard extends StatelessWidget {
  final List<String> images;

  const CarouselCard({Key? key, required this.images}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      constraints: const BoxConstraints(
        maxWidth: 400, // Lebar maksimum yang valid
        minWidth: 200, // Lebar minimum yang valid
      ),
      child: Card(
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(15.0),
        ),
        elevation: 4,
        margin: const EdgeInsets.all(16),
        child: SizedBox(
          width: double.infinity,
          height: 100,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            itemCount: images.length,
            itemBuilder: (BuildContext context, int index) {
              return SizedBox(
                width: 400, // Lebar sesuai dengan gambar
                child: Image.asset(
                  images[index],
                  fit: BoxFit.cover,
                ),
              );
            },
          ),
        ),
      ),
    );
  }
}

class CourseCard extends StatelessWidget {
  const CourseCard({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return SizedBox(
      height: 197,
      child: ListView.builder(
        scrollDirection: Axis.horizontal,
        itemCount: 5,
        itemBuilder: (BuildContext context, int index) {
          return Container(
            width: 180, // Lebar sesuai dengan jumlah item
            margin: const EdgeInsets.all(8),
            child: Card(
              elevation: 4,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(15.0),
              ),
              child: Center(
                child: Text('Card ${index + 1}'),
              ),
            ),
          );
        },
      ),
    );
  }
}
