//
//  UIButtonGroup.m
//  ChinesePokerHD
//
//  Created by kidliuxu on 13-11-14.
//  Copyright (c) 2013年 Fans Media Co. Ltd. All rights reserved.
//

#import "UIButtonGroup.h"

@implementation UIButtonGroup

- (id)initWithFrame:(CGRect)frame
{
    self = [super initWithFrame:frame];
    if (self) {
        // Initialization code
    }
    return self;
}

-(void) didCreateViewComplete
{
    [super didCreateViewComplete];
    int i = 0;
    for (UIButton *item in self.itemList)
    {
        [item setTag:i];
        [item addTarget:self action:@selector(didBtnClicked:) forControlEvents:UIControlEventTouchUpInside];
        i++;
    }
}

-(void) setDelegate:(id<UIButtonGroupDelegate>) delegate
{
    self.myDelegate = delegate;
}

- (void)didBtnClicked:(UIButton *) btn
{
    if(self.myDelegate)
    {
        [self.myDelegate didUIButtonClicked:btn];
    }
}

/*
// Only override drawRect: if you perform custom drawing.
// An empty implementation adversely affects performance during animation.
- (void)drawRect:(CGRect)rect
{
    // Drawing code
}
*/

@end
